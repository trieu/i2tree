package com.mc2ads.browser;

import static com.mc2ads.browser.CommonUtilities.DISPLAY_MESSAGE_ACTION;
import static com.mc2ads.browser.CommonUtilities.EXTRA_MESSAGE;
import static com.mc2ads.browser.CommonUtilities.SENDER_ID;
import static com.mc2ads.browser.CommonUtilities.SERVER_URL;
import android.annotation.SuppressLint;
import android.app.Activity;
import android.content.BroadcastReceiver;
import android.content.ContentResolver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.provider.Settings;
import android.telephony.TelephonyManager;
import android.util.Log;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.webkit.ValueCallback;
import android.webkit.WebSettings;
import android.webkit.WebView;

import com.google.android.gcm.GCMRegistrar;

public class Mc2AdsMainView extends Activity {

	WebView mWebView;
	final Mc2AdsChromeClient chromeClient = new Mc2AdsChromeClient(this);
	final Mc2AdsWebViewClient viewClient = new Mc2AdsWebViewClient();
	ActiveInfoView activeInfoView;
	public ValueCallback<Uri> mUploadMessage;  
	public final static int FILECHOOSER_RESULTCODE=1;  

	AsyncTask<Void, Void, Void> mRegisterTask;

	public String getNetworkType() {
		ConnectivityManager connec = (ConnectivityManager) this
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		android.net.NetworkInfo wifi = connec
				.getNetworkInfo(ConnectivityManager.TYPE_WIFI);
		android.net.NetworkInfo mobile = connec
				.getNetworkInfo(ConnectivityManager.TYPE_MOBILE);

		if (wifi.isConnected()) {
			return "wifi";
		} else if (mobile.isConnected()) {
			return "mobile_network";
		}
		return "";
	}

	public boolean isNetworkAvailable() {
		Context context = getApplicationContext();
		ConnectivityManager connectivity = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);
		if (connectivity == null) {
			Log.e("isNetworkAvailable", "connectivity is NULL");
		} else {
			NetworkInfo[] info = connectivity.getAllNetworkInfo();
			if (info != null) {
				for (int i = 0; i < info.length; i++) {
					if (info[i].getState() == NetworkInfo.State.CONNECTED) {
						return true;
					}
				}
			}
		}
		return false;
	}

	Runnable getDeviceToken = new Runnable() {
		public void run() {
			TelephonyManager telephonyManager = (TelephonyManager) getSystemService(Context.TELEPHONY_SERVICE);
			String deviceId = telephonyManager.getDeviceId() + "";
			Log.e("getDeviceToken", deviceId);

			// TODO send to server
		}
	};

	void updateFullscreenStatus(boolean bUseFullscreen) {
		if (bUseFullscreen) {
			getWindow().addFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN);
			getWindow().clearFlags(WindowManager.LayoutParams.FLAG_FORCE_NOT_FULLSCREEN);
		} else {
			getWindow().addFlags(WindowManager.LayoutParams.FLAG_FORCE_NOT_FULLSCREEN);
			getWindow().clearFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN);
		}

		mWebView.requestLayout();
	
	}

	
	@SuppressLint("SetJavaScriptEnabled")
	void setConfigsWebView() {
		mWebView.setWebChromeClient(chromeClient);
		mWebView.setScrollBarStyle(View.SCROLLBARS_INSIDE_OVERLAY);
		
		WebSettings settings = mWebView.getSettings();
		settings.setJavaScriptEnabled(true);
		settings.setSavePassword(true);
		settings.setCacheMode(WebSettings.LOAD_NORMAL);
		settings.setAppCacheEnabled(true);
		settings.setJavaScriptCanOpenWindowsAutomatically(true);
		settings.setGeolocationEnabled(true);
		settings.setSupportZoom(true);
		settings.setAllowFileAccess(true);
		
	
		mWebView.setWebViewClient(viewClient);
		// mWebView.getSettings().setBuiltInZoomControls(true);
		// mWebView.getSettings().setUseWideViewPort(true);
		// mWebView.getSettings().setLoadWithOverviewMode(true);

		chromeClient.onGeolocationPermissionsShowPrompt("", chromeClient);
	}

	public static void setAutoOrientationEnabled(ContentResolver resolver, boolean enabled)
	{
	  Settings.System.putInt(resolver, Settings.System.ACCELEROMETER_ROTATION, enabled ? 1 : 0);
	}

	
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		// Adds Progrss bar Support

		this.getWindow().requestFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.main);

		// Get Web view
		mWebView = (WebView) findViewById(R.id.MyWebview);
		updateFullscreenStatus(true);
		//setAutoOrientationEnabled(getContentResolver(), false);
		setConfigsWebView();
				
		// inject some js modules
		mWebView.addJavascriptInterface(new GSLog(this), "GSLog");		
		mWebView.addJavascriptInterface(UserUtil.theInstance(),	"UserUtil");
			

		// Sets the Chrome Client, and defines the onProgressChanged, This makes
		// the Progress bar be updated.
		
		this.activeInfoView = new ActiveInfoView(this, mWebView);
		this.activeInfoView.loadHTML();
		viewClient.setActiveInfoView(activeInfoView);
		mWebView.addJavascriptInterface(FacebookUserUtil.theInstance(this.activeInfoView),	"FacebookUserUtil");

		checkConfigsGCM();
		autoRegisterGCM();
	}

	void checkConfigsGCM() {
		checkNotNull(SERVER_URL, "SERVER_URL");
		checkNotNull(SENDER_ID, "SENDER_ID");
		// Make sure the device has the proper dependencies.
		GCMRegistrar.checkDevice(this);
		// Make sure the manifest was properly set - comment out this line
		// while developing the app, then uncomment it when it's ready.
		GCMRegistrar.checkManifest(this);
		registerReceiver(mHandleMessageReceiver, new IntentFilter(DISPLAY_MESSAGE_ACTION));
	}

	void autoRegisterGCM() {

		final String regId = GCMRegistrar.getRegistrationId(this);
		if (regId.equals("")) {
			// skip Automatically registers application on startup.
			GCMRegistrar.register(this, SENDER_ID);
		} else {
			// Device is already registered on GCM, needs to check if it is
			// registered on our server as well.
			if (GCMRegistrar.isRegisteredOnServer(this)) {
				// Skips registration.
				// TODO
				// mDisplay.append(getString(R.string.already_registered));
			} else {
				// Try to register again, but not in the UI thread.
				// It's also necessary to cancel the thread onDestroy(),
				// hence the use of AsyncTask instead of a raw thread.
				final Context context = this;
				mRegisterTask = new AsyncTask<Void, Void, Void>() {

					@Override
					protected Void doInBackground(Void... params) {
						boolean registered = ServerUtilities.register(context,regId);
						
						// At this point all attempts to register with the app
						// server failed, so we need to unregister the device
						// from GCM - the app will try to register again when
						// it is restarted. Note that GCM will send an
						// unregistered callback upon completion, but
						// GCMIntentService.onUnregistered() will ignore it.
						if (!registered) {
							GCMRegistrar.unregister(context);
						}
						return null;
					}

					@Override
					protected void onPostExecute(Void result) {
						mRegisterTask = null;
					}

				};
				mRegisterTask.execute(null, null, null);
			}
		}
	}
	
	@Override
	protected void onActivityResult(int requestCode, int resultCode,
	        Intent intent) {
	    if (requestCode == FILECHOOSER_RESULTCODE) {
	        if (null == mUploadMessage)
	            return;
	        Uri result = intent == null || resultCode != RESULT_OK ? null
	                : intent.getData();
	        mUploadMessage.onReceiveValue(result);
	        mUploadMessage = null;

	    }
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		MenuInflater inflater = getMenuInflater();
		inflater.inflate(R.menu.options_menu, menu);
		return true;
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		switch (item.getItemId()) {
		/*
		 * Typically, an application registers automatically, so options below
		 * are disabled. Uncomment them if you want to manually register or
		 * unregister the device (you will also need to uncomment the equivalent
		 * options on options_menu.xml).
		 */
		/*
		 * case R.id.options_register: GCMRegistrar.register(this, SENDER_ID);
		 * return true; case R.id.options_unregister:
		 * GCMRegistrar.unregister(this); return true;
		 */
		case R.id.options_clear:
			// mDisplay.setText(null); //TODO
			return true;
		case R.id.options_exit:
			finish();
			return true;
		default:
			return super.onOptionsItemSelected(item);
		}
	}

	@Override
	protected void onDestroy() {
		if (mRegisterTask != null) {
			mRegisterTask.cancel(true);
		}
		unregisterReceiver(mHandleMessageReceiver);
		GCMRegistrar.onDestroy(this);
		super.onDestroy();
	}
	

	private void checkNotNull(Object reference, String name) {
		if (reference == null) {
			throw new NullPointerException(getString(R.string.error_config,
					name));
		}
	}

	private final BroadcastReceiver mHandleMessageReceiver = new BroadcastReceiver() {
		@Override
		public void onReceive(Context context, Intent intent) {
			String msg = intent.getExtras().getString(EXTRA_MESSAGE);
			Log.i("mHandleMessageReceiver", msg);
			SoundUtil.makeDefaultNotificationSound(Mc2AdsMainView.this, 2);			
			
			
			msg = msg.replace("\"", "'");			
	        String js =  "javascript: refreshData(\""+ msg +"\")";
	        mWebView.loadUrl(js);
		}
	};
}

