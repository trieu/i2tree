package com.i2tree.browser;

import java.util.Random;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.content.Context;
import android.util.Log;
import android.webkit.WebView;

public class LoLPhotosManager {
	
	private static JSONArray jsonArray = null;
	private static void initData(){
		if (jsonArray == null) {
			String url = "http://lolturtleapp.appspot.com/api?action=getItemListCache";
			String json = HttpClientUtils.executeGet(url);
			// System.out.println(html);
			try {
				jsonArray = new JSONArray(json);
				// for (int i = 0; i < array.length(); i++) {
				// JSONObject obj = array.getJSONObject(i);
				// Log.e("getImageList", i + "-" + obj.getString("source"));
				// }

			} catch (JSONException e) {				
				e.printStackTrace();
			}
		}
	}
	
	public int getPhotoNumber(){
		if (jsonArray != null) {
			return jsonArray.length();
		}
		return 0;
	}
	
	Context context;
    WebView webView;

	public String getImageSrcFromCloud() {
		if (jsonArray != null) {
			try {
				Random ran = new Random();
				int r = ran.nextInt(jsonArray.length()) + 1;
				JSONObject obj = jsonArray.getJSONObject(r);
				String imgSrc = obj.getString("source");
				return imgSrc;
			} catch (JSONException e) {				
				e.printStackTrace();
			}
		}
		return "";
	}
	
	public String getImageSrcFromCloud(int start, int total) {
		if (jsonArray != null) {
			try {
				StringBuilder sb = new StringBuilder();
				
				int stop = start + total;
				if(start < jsonArray.length())
				for (int  i = start; i < stop; i++) { 
					JSONObject obj = jsonArray.getJSONObject(i);
					String imgSrc = obj.getString("source");
					String title = obj.getString("title").replace("\"", " ");
					String img = "<li><a href='"+imgSrc+"?type=normal' rel=\"external\"><img src='"+imgSrc+"?type=normal' alt=\""+title+"\" /></a></li>";
					sb.append(img);
					Log.e("getImageSrcFromCloud", img);
				}
				
				return sb.toString();
			} catch (JSONException e) {				
				e.printStackTrace();
			}
		}
		return "";
	}
	
	public void getImageSrcFromCloud(int start, int total, String callback) {
        //when I log callback, it is "undefined"
         String url = getImageSrcFromCloud();
         String js =
             "javascript:(function() { "
                 + "var callback = " + callback + ";"
                 + "callback('" + url + "');"
             + "})()";
        webView.loadUrl(js);
    }
	
	public void getImageSrcFromCloud(String callback) {
        //when I log callback, it is "undefined"
         String url = getImageSrcFromCloud();
         String js =
             "javascript:(function() { "
                 + "var callback = " + callback + ";"
                 + "callback('" + url + "');"
             + "})()";
        webView.loadUrl(js);
    }
	
	
	
	public LoLPhotosManager(Context context, WebView webView) {
		super();
		initData();
		this.context = context;
		this.webView = webView;
	}

}
