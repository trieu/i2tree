package com.i2tree.managers;

import java.io.File;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.content.pm.PackageManager;
import android.net.Uri;
import android.util.Log;

import com.dropbox.client2.DropboxAPI;
import com.dropbox.client2.android.AndroidAuthSession;
import com.dropbox.client2.android.AuthActivity;
import com.dropbox.client2.session.AccessTokenPair;
import com.dropbox.client2.session.AppKeyPair;
import com.dropbox.client2.session.Session.AccessType;
import com.dropbox.client2.session.TokenPair;
import com.i2tree.tasks.UploadPicture;

public class DropboxApiClientManager {

	final static private String APP_KEY = "8d2kln7x9xpchnj";
	final static private String APP_SECRET = "g3afhlbffx395ep";
	final static private AccessType ACCESS_TYPE = AccessType.DROPBOX;

	final static private String ACCOUNT_PREFS_NAME = "prefs";
	final static private String ACCESS_KEY_NAME = "ACCESS_KEY";
	final static private String ACCESS_SECRET_NAME = "ACCESS_SECRET";

	DropboxAPI<AndroidAuthSession> mApi;
	private boolean mLoggedIn;
	private final String PHOTO_DIR = "/Photos/";

	final static private int NEW_PICTURE = 1;
	private static final String TAG = DropboxApiClientManager.class.getName();
	private String mCameraFileName;
	Activity activity;
	
	static DropboxApiClientManager _instance = null;
	public static final DropboxApiClientManager theInstance(Activity activity) {
		if(_instance == null){
			_instance = new DropboxApiClientManager(activity);
		}
		return _instance;
	}
	
	protected DropboxApiClientManager(){}

	protected DropboxApiClientManager(Activity activity) {
		this.activity = activity;
		
		Log.i(TAG, "DropboxApiClientManager init");
		
        // We create a new AuthSession so that we can use the Dropbox API.
        AndroidAuthSession session = buildSession();
        mApi = new DropboxAPI<AndroidAuthSession>(session);
        
        checkAppKeySetup();
	}
	
	
    private void checkAppKeySetup() {
        // Check to make sure that we have a valid app key
        if (APP_KEY.startsWith("CHANGE") ||
                APP_SECRET.startsWith("CHANGE")) {
            showToast("You must apply for an app key and secret from developers.dropbox.com, and add them to the DBRoulette ap before trying it.");
            activity.finish();
            return;
        }

        // Check if the app has set up its manifest properly.
        Intent testIntent = new Intent(Intent.ACTION_VIEW);
        String scheme = "db-" + APP_KEY;
        String uri = scheme + "://" + AuthActivity.AUTH_VERSION + "/test";
        testIntent.setData(Uri.parse(uri));
        PackageManager pm = activity.getPackageManager();
        if (0 == pm.queryIntentActivities(testIntent, 0).size()) {
            showToast("URL scheme in your app's " +
                    "manifest is not set up correctly. You should have a " +
                    "com.dropbox.client2.android.AuthActivity with the " +
                    "scheme: " + scheme);
            activity.finish();
        }
    }
    
    public DropboxAPI<AndroidAuthSession> getmApi() {
		return mApi;
	}

	public void logIn() {

		
		setLoggedIn(mApi.getSession().isLinked());
		mApi.getSession().startAuthentication(this.activity);
		

	}

	public void logOut() {
		// Remove credentials from the session
		mApi.getSession().unlink();

		// Clear our stored keys
		clearKeys();
		// Change UI state to display logged out version
		setLoggedIn(false);
	}

	/**
	 * Convenience function to change UI state based on being logged in
	 */
	public void setLoggedIn(boolean loggedIn) {
		mLoggedIn = loggedIn;
		Log.d("DropboxPlugin", "loggedIn " + loggedIn);
		if (loggedIn) {
			// mSubmit.setText("Unlink from Dropbox");
			// mDisplay.setVisibility(View.VISIBLE);
		} else {
			// mSubmit.setText("Link with Dropbox");
			// mDisplay.setVisibility(View.GONE);
			// mImage.setImageDrawable(null);
		}
	}

	/**
	 * Shows keeping the access keys returned from Trusted Authenticator in a
	 * local store, rather than storing user name & password, and
	 * re-authenticating each time (which is not to be done, ever).
	 * 
	 * @return Array of [access_key, access_secret], or null if none stored
	 */
	public String[] getKeys() {
		SharedPreferences prefs = activity.getSharedPreferences(
				ACCOUNT_PREFS_NAME, 0);
		String key = prefs.getString(ACCESS_KEY_NAME, null);
		String secret = prefs.getString(ACCESS_SECRET_NAME, null);
		if (key != null && secret != null) {
			String[] ret = new String[2];
			ret[0] = key;
			ret[1] = secret;
			return ret;
		} else {
			return null;
		}
	}

	/**
	 * Shows keeping the access keys returned from Trusted Authenticator in a
	 * local store, rather than storing user name & password, and
	 * re-authenticating each time (which is not to be done, ever).
	 */
	public void storeKeys(String key, String secret) {
		// Save the access key for later
		SharedPreferences prefs = activity.getSharedPreferences(
				ACCOUNT_PREFS_NAME, 0);
		Editor edit = prefs.edit();
		edit.putString(ACCESS_KEY_NAME, key);
		edit.putString(ACCESS_SECRET_NAME, secret);
		edit.commit();
	}

	public void clearKeys() {
		SharedPreferences prefs = activity.getSharedPreferences(
				ACCOUNT_PREFS_NAME, 0);
		Editor edit = prefs.edit();
		edit.clear();
		edit.commit();
	}

	public AndroidAuthSession buildSession() {
		AppKeyPair appKeyPair = new AppKeyPair(APP_KEY, APP_SECRET);
		AndroidAuthSession session;

		String[] stored = getKeys();
		if (stored != null) {
			AccessTokenPair accessToken = new AccessTokenPair(stored[0],
					stored[1]);
			session = new AndroidAuthSession(appKeyPair, ACCESS_TYPE,
					accessToken);
		} else {
			session = new AndroidAuthSession(appKeyPair, ACCESS_TYPE);
		}

		return session;
	}

	private void showToast(String msg) {
		Log.e(TAG, msg);
	}

	public void onResumeHandler() {
		AndroidAuthSession session = mApi.getSession();

		// The next part must be inserted in the onResume() method of the
		// activity from which session.startAuthentication() was called, so
		// that Dropbox authentication completes properly.
		if (session.authenticationSuccessful()) {
			try {
				// Mandatory call to complete the auth
				session.finishAuthentication();

				// Store it locally in our app for later use
				TokenPair tokens = session.getAccessTokenPair();
				storeKeys(tokens.key, tokens.secret);
				setLoggedIn(true);
			} catch (IllegalStateException e) {
				showToast("Couldn't authenticate with Dropbox:"
						+ e.getLocalizedMessage());
				Log.i(TAG, "Error authenticating", e);
			}
		}
	}

	public void onActivityResultHandler(int requestCode, int resultCode,
			Intent data) {
		if (requestCode == NEW_PICTURE) {
			// return from file upload
			if (resultCode == Activity.RESULT_OK) {
				Uri uri = null;
				if (data != null) {
					uri = data.getData();
				}
				if (uri == null && mCameraFileName != null) {
					uri = Uri.fromFile(new File(mCameraFileName));
				}
				File file = new File(mCameraFileName);

				if (uri != null) {
					UploadPicture upload = new UploadPicture(this.activity, mApi,PHOTO_DIR, file);
					upload.execute();
				}
			} else {
				Log.w(TAG, "Unknown Activity Result from mediaImport: "
						+ resultCode);
			}
		}
	}
}
