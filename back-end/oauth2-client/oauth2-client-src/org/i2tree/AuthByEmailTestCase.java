package org.i2tree;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

import org.apache.commons.codec.binary.Base64;
import org.i2tree.utils.HttpClientUtil;
import org.i2tree.utils.StringUtil;
import org.json.JSONException;


public class AuthByEmailTestCase {
	//static final String BASE_URL = "http://localhost/usersystem";

	// static final String BASE_URL = "http://184.106.69.13/elgg";
	static final String BASE_URL = "https://www.greengarstudios.com/usersystem";
	//static final String BASE_URL = "http://localhost/usersystem2";
	//3b21425f90fbcc084db78128c22218a77e86645c3b4ba5b8c812cd5b555e5b10
	//3b21425f90fbcc084db78128c22218a77e86645c3b4ba5b8c812cd5b555e5b10
	/**
	 * @param args
	 * @throws InterruptedException
	 */
	public static void main(String[] args) throws InterruptedException {
		//String url = BASE_URL + "/pg/greengar/oauth2/token";
		
		try {
			//System.out.println(StringUtil.sha256("/art.php?id=209704").length());
			
			String json = "{\"access_token\":\"0b0e63671aa4a18756d7931e117ab000\",\"expires_in\":3600,\"scope\":null,\"refresh_token\":\"d1ab4d9696e8f8cd266decd0633a35fa\",\"user_id\":430357,\"coins\":{\"coins\":\"360\",\"timestamp\":1343375771}}";
			OAuth2Tokens tokens = new OAuth2Tokens(json);
			
			String email = "trieu@greengar.com";		
			String password = "qwerty";
			tokens = login(email, password);
			//getUserInfo(tokens);
			//doLike(tokens);
			doComment(tokens);
		} catch (Exception e) {			
			e.printStackTrace();
		}
		//{"status":200,"result":{"access_token":"1d2fa8fe92ca89fda53298bca27c0aac","expires_in":3600,"scope":null,"refresh_token":"5c30259f73e63aa493a42f30ce79e688"}}
		//{"status":200,"result":{"access_token":"604f21dc947477587a71eb501fe2d410","expires_in":3600,"scope":null,"refresh_token":"92a533c1cfb57a00d9471aa00c3ac650"}}
		//{"access_token":"a8da3502f5fd160a2057b6a424e313d9","expires_in":3600,"scope":null,"refresh_token":"1f706a937bef062bc21006392358a07a"}
		//{"access_token":"335c049151c6dd1a55ce67ca284e3607","expires_in":3600,"scope":null,"refresh_token":"67df084c214e07825103632c6417b4c3"}
		
	}
	//https://github.com/nxtbgthng/OAuth2Client/blob/master/Sources/OAuth2Client/NXOAuth2Connection.m
	//{"access_token":"de040b9580cb6d243162bda61f202a8f","expires_in":3600,"scope":null,"refresh_token":"b5f1bc94b1463755d0f9c9ed023092d3","user_id":"430357","coins":{"coins":"360","timestamp":1343375771},"purchases":["com.greengar.drawtogether.pro"],"reputation":0}
	
	static OAuth2Tokens login(String email,String password) throws JSONException{
		String url = BASE_URL + "/pg/greengar/user/auth_by_email";
		System.out.println(url);
	
		String timestamp = "" + System.currentTimeMillis();

		String sourceStr = email + ",,,,," + timestamp;

		byte[] encoded = Base64.encodeBase64(sourceStr.getBytes());
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
	
	static void getUserInfo(OAuth2Tokens auth2Result) throws MalformedURLException, JSONException{
		StringBuilder url = new StringBuilder(BASE_URL + "/pg/greengar/user/get_user?");
		url.append("user_id=me&client=whiteboard&brief=false");
		System.out.println(url);
		String oauthHeader = "OAuth access_token=\"" + auth2Result.getAccess_token() + "\" " ;
		String json = HttpClientUtil.executeGet(new URL(url.toString()), false , oauthHeader);
		if(json.equals("500")){
			auth2Result = refreshToken(auth2Result);
			oauthHeader = "OAuth access_token=\"" + auth2Result.getAccess_token() + "\" " ;
			json = HttpClientUtil.executeGet(new URL(url.toString()), false , oauthHeader);
		}
		System.out.println(json);
	}
	
	static void doRating(OAuth2Tokens auth2Result) throws MalformedURLException, JSONException{
		StringBuilder url = new StringBuilder(BASE_URL + "/pg/greengar/user/rating?");		
		System.out.println(url);
		String oauthHeader = "OAuth access_token=\"" + auth2Result.getAccess_token() + "\" " ;
		Map<String, String> params = new HashMap<String, String>();
		params.put("url", "http%3A%2F%2Fwww.greengar.com%2F");
		params.put("rating", "2");
		
		String json = HttpClientUtil.executePost( (url.toString()), params , oauthHeader);
		if(json.equals("500")){
			auth2Result = refreshToken(auth2Result);
			oauthHeader = "OAuth access_token=\"" + auth2Result.getAccess_token() + "\" " ;
			json = HttpClientUtil.executePost( (url.toString()), params , oauthHeader);
		}
		System.out.println(json);
	}
	
	static void doLike(OAuth2Tokens auth2Result) throws MalformedURLException, JSONException{
		StringBuilder url = new StringBuilder(BASE_URL + "/pg/greengar/user/like?");		
		System.out.println(url);
		String oauthHeader = "OAuth access_token=\"" + auth2Result.getAccess_token() + "\" " ;
		Map<String, String> params = new HashMap<String, String>();
		params.put("url", "http%3A%2F%2Fwww.greengar.com%2F");
		
		String json = HttpClientUtil.executePost( (url.toString()), params , oauthHeader);
		if(json.equals("500")){
			auth2Result = refreshToken(auth2Result);
			oauthHeader = "OAuth access_token=\"" + auth2Result.getAccess_token() + "\" " ;
			json = HttpClientUtil.executePost( (url.toString()), params , oauthHeader);
		}
		System.out.println(json);
	}
	
	static void doUnLike(OAuth2Tokens auth2Result) throws MalformedURLException, JSONException{
		StringBuilder url = new StringBuilder(BASE_URL + "/pg/greengar/user/unlike?");		
		System.out.println(url);
		String oauthHeader = "OAuth access_token=\"" + auth2Result.getAccess_token() + "\" " ;
		Map<String, String> params = new HashMap<String, String>();
		params.put("url", "http%3A%2F%2Fwww.greengar.com%2F");
		
		String json = HttpClientUtil.executePost( (url.toString()), params , oauthHeader);
		if(json.equals("500")){
			auth2Result = refreshToken(auth2Result);
			oauthHeader = "OAuth access_token=\"" + auth2Result.getAccess_token() + "\" " ;
			json = HttpClientUtil.executePost( (url.toString()), params , oauthHeader);
		}
		System.out.println(json);
	}
	
	
	
	static void doComment(OAuth2Tokens auth2Result) throws MalformedURLException, JSONException{
		StringBuilder url = new StringBuilder(BASE_URL + "/pg/greengar/user/comment?");		
		System.out.println(url);
		String oauthHeader = "OAuth access_token=\"" + auth2Result.getAccess_token() + "\" " ;
		Map<String, String> params = new HashMap<String, String>();
		params.put("url", "http%3A%2F%2Fwww.greengar.com%2F");
		params.put("comment", "đây là bình luận 2");
		
		String json = HttpClientUtil.executePost( (url.toString()), params , oauthHeader);
		if(json.equals("500")){
			auth2Result = refreshToken(auth2Result);
			oauthHeader = "OAuth access_token=\"" + auth2Result.getAccess_token() + "\" " ;
			json = HttpClientUtil.executePost( (url.toString()), params , oauthHeader);
		}
		System.out.println(json);
	}
	
	static void removeComment(OAuth2Tokens auth2Result) throws MalformedURLException, JSONException{
		StringBuilder url = new StringBuilder(BASE_URL + "/pg/greengar/user/remove_comment?");		
		System.out.println(url);
		String oauthHeader = "OAuth access_token=\"" + auth2Result.getAccess_token() + "\" " ;
		Map<String, String> params = new HashMap<String, String>();
		params.put("url", "http%3A%2F%2Fwww.greengar.com%2F");
		params.put("comment_id", "32");
		
		String json = HttpClientUtil.executePost( (url.toString()), params , oauthHeader);
		if(json.equals("500")){
			auth2Result = refreshToken(auth2Result);
			oauthHeader = "OAuth access_token=\"" + auth2Result.getAccess_token() + "\" " ;
			json = HttpClientUtil.executePost( (url.toString()), params , oauthHeader);
		}
		System.out.println(json);
	}

}
