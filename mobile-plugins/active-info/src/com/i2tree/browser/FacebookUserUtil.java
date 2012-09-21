package com.i2tree.browser;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;

import org.apache.http.client.utils.URLEncodedUtils;
import org.json.JSONException;
import org.json.JSONObject;

import android.util.Log;

public class FacebookUserUtil {

	static FacebookUserUtil theInstance ;
	ActiveInfoView activeInfoView;
	static String access_token;
	
	public static FacebookUserUtil theInstance(ActiveInfoView activeInfoView){
		if(theInstance == null){
			theInstance = new FacebookUserUtil(activeInfoView);
		}
		return theInstance;
	}
	
	public static FacebookUserUtil theInstance(){
		if(theInstance == null){
			throw new IllegalAccessError("activeInfoView is null"); 
		}
		return theInstance;
	}

	protected FacebookUserUtil(ActiveInfoView activeInfoView) {
		this.activeInfoView = activeInfoView;
	}
	
	JSONObject fbUserData;
	
	public void setFbUserData(String json) {
		if(json.equals("")){
			activeInfoView.callJsFunction(" fbLoginOk(false) " );
			return;
		}
		try {
			fbUserData = new JSONObject(json);
			String name = fbUserData.getString("name");
			Log.i("FacebookUserUtil", name);
			activeInfoView.callJsFunction(" fbLoginOk('" + name + "') " );
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	public void logout(){
		android.webkit.CookieManager.getInstance().removeAllCookie();
		activeInfoView.loadHTML();
		access_token = "";
	}
	
	public String getFbUserData(String key) {
		String val = "";
		if(fbUserData != null){
			try {
				val = fbUserData.getString(key);
				if(val == null){
					val = "";
				}
			} catch (JSONException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
		return val;
	}
	
	public void setAccessToken(String access_token) {
		FacebookUserUtil.access_token = access_token;
	}
	
	public String postToMyWall(String message){
		try {
			message = URLEncoder.encode(message,"utf-8");
		} catch (UnsupportedEncodingException e) {
		}
		StringBuilder url = new StringBuilder("https://graph.facebook.com/me/feed?");
		url.append("message=").append(message);
		url.append("&caption=my%20app&picture=http%3A%2F%2Fstatic.guim.co.uk%2Fsys-images%2FGuardian%2FPix%2Fpictures%2F2009%2F9%2F18%2F1253287439918%2FEmoticon-001.jpg&method=post&access_token=");
		url.append(access_token);
		Log.i("postToMyWall", url.toString());
		return HttpClientUtil.executeGet(url.toString());
		
	}
	
}
