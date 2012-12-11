package com.mc2ads.browser;


import java.net.URLEncoder;
import java.util.HashMap;
import java.util.Map;

import org.json.JSONException;

import android.util.Base64;
import android.util.Log;

public class UserUtil {
	final static UserUtil theInstance = new UserUtil();
	static OAuth2Tokens auth2Tokens;
	
	public static UserUtil theInstance(){
		return theInstance;
	}
	
	protected UserUtil() {
		// TODO Auto-generated constructor stub
	}
	
	public static int getUserId(){
		//TODO
		return 430357;
	}
	
	static final String BASE_URL = "https://www.greengarstudios.com/usersystem";

	static OAuth2Tokens login(String email,String password) throws JSONException{
		String url = BASE_URL + "/pg/greengar/user/auth_by_email";
		System.out.println(url);	
		String timestamp = "" + System.currentTimeMillis();

		String sourceStr = email + ",,,,," + timestamp;

		byte[] encoded = Base64.encode(sourceStr.getBytes(),Base64.DEFAULT);
		String signature = StringUtil.sha1(encoded);
		

		Map<String, String> params = new HashMap<String, String>();
		params.put("email", email);
		
		params.put("username", email );
		params.put("password", password);
		
		params.put("timestamp", timestamp);
		params.put("signature", signature);
		
		params.put("grant_type", "password");
		params.put("client_id", "dtt_local");
		params.put("client_secret", "123456");
		
		//app-scheme url
		params.put("redirect_uri", "http://localhost/i2tree-framework/front-end/");
		
		params.put("first_name", "");
		params.put("last_name", "");
		params.put("avatar_url", "");
		params.put("facebook_id", "");

		String json = HttpClientUtil.executePost(url, params ,"" );
		System.out.println(json);
		return new OAuth2Tokens(json);
	}
	
	static OAuth2Tokens refreshToken(OAuth2Tokens auth2Result) throws JSONException{
		String url = BASE_URL + "/pg/greengar/oauth2/token";
		System.out.println(url);
	
		String timestamp = "" + System.currentTimeMillis();

		Map<String, String> params = new HashMap<String, String>();
		
		params.put("timestamp", timestamp);
		params.put("client_id", "dtt_local");
		params.put("client_secret", "123456");
		params.put("refresh_token", auth2Result.getRefresh_token());

		params.put("grant_type", "refresh_token");	

		String json = HttpClientUtil.executePost(url, params ,"" );
		System.out.println(json);
		return new OAuth2Tokens(json);
	}
	
	
	
	public boolean like(String imgSrc) {
		try {
			if(auth2Tokens == null){
				String email = "trieu@greengar.com";		
				String password = "qwerty";
				auth2Tokens = UserUtil.login(email, password);
				Log.i("GreengarUserUtil", auth2Tokens.getAccess_token());
			}
			
			StringBuilder url = new StringBuilder(BASE_URL + "/pg/greengar/user/like?");		
			System.out.println(url);
			String oauthHeader = "OAuth access_token=\"" + auth2Tokens.getAccess_token() + "\" " ;
			Map<String, String> params = new HashMap<String, String>();
			params.put("url", URLEncoder.encode(imgSrc, "UTF-8") );

			String json = HttpClientUtil.executePost( (url.toString()), params , oauthHeader);
			if(json.equals("500")){
				auth2Tokens = refreshToken(auth2Tokens);
				oauthHeader = "OAuth access_token=\"" + auth2Tokens.getAccess_token() + "\" " ;
				json = HttpClientUtil.executePost( (url.toString()), params , oauthHeader);
			}
			System.out.println(json);
		} catch (Exception e) {
			e.printStackTrace();
			Log.e("GreengarUserUtil", e.getMessage());
		}
		return true;
	}
}
