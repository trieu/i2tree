package org.i2tree;

import org.json.JSONException;
import org.json.JSONObject;



public class OAuth2Tokens {
	//{"access_token":"49e025b198b0dc95c7e615fbe53d72e6","expires_in":3600,"scope":null,"refresh_token":"e30fa6b8dc98dafada5926fe7ee7fa07","user_id":"430357","coins":{"coins":"360","timestamp":1343369517},"purchases":["com.greengar.drawtogether.pro"],"reputation":0}
	//{"status":200,"result":{"access_token":"604f21dc947477587a71eb501fe2d410","expires_in":3600,"scope":null,"refresh_token":"92a533c1cfb57a00d9471aa00c3ac650"}}
	
	int status;
	String access_token;
	int expires_in;
	String scope;
	String refresh_token;
	int user_id ;
	
	public OAuth2Tokens(String json) throws JSONException{
		JSONObject jsonObj = new JSONObject(json);
		
		if(jsonObj.has("status")){
			this.status = jsonObj.getInt("status");
			JSONObject result = jsonObj.getJSONObject("result");
			this.expires_in = result.getInt("expires_in");
			this.scope = result.getString("scope");
			this.access_token = result.getString("access_token");
			this.refresh_token = result.getString("refresh_token");		
		} else if(jsonObj.has("access_token")){
			this.expires_in = jsonObj.getInt("expires_in");
			this.scope = jsonObj.getString("scope");
			this.access_token = jsonObj.getString("access_token");
			this.refresh_token = jsonObj.getString("refresh_token");
			this.user_id = jsonObj.getInt("user_id");
		}
		
	}

	public int getStatus() {
		return status;
	}

	public void setStatus(int status) {
		this.status = status;
	}

	public String getAccess_token() {
		return access_token;
	}

	public void setAccess_token(String access_token) {
		this.access_token = access_token;
	}

	public int getExpires_in() {
		return expires_in;
	}

	public void setExpires_in(int expires_in) {
		this.expires_in = expires_in;
	}

	public String getScope() {
		return scope;
	}

	public void setScope(String scope) {
		this.scope = scope;
	}

	public String getRefresh_token() {
		return refresh_token;
	}

	public void setRefresh_token(String refresh_token) {
		this.refresh_token = refresh_token;
	}

	public int getUser_id() {
		return user_id;
	}

	public void setUser_id(int user_id) {
		this.user_id = user_id;
	}
	
	

}
