package com.mc2ads.browser;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.Random;

import android.app.Activity;
import android.content.Context;
import android.content.res.AssetManager;
import android.util.Log;
import android.view.Display;
import android.view.WindowManager;
import android.webkit.WebView;

public class ActiveInfoView {
	final String mimeType = "text/html";
	final String encoding = "UTF-8";
	final String mainHtmlFile = "www/active-info-main.html";
	
	AssetManager assetManager;
	WebView mWebView;
	Activity activity;

	public Activity getActivity() {
		return activity;
	}
	
//	Random ran = new Random();
//	int r = ran.nextInt(loLPhotosManager.getPhotoNumber()) + 1;
//	loadGaLleryView(r, 6);
	
	public ActiveInfoView(Activity activity, WebView mWebView) {
		this.activity = activity;
		this.assetManager = activity.getAssets();
		this.mWebView = mWebView;
	}
	
	public void callJsFunction(String js){
		this.mWebView.loadUrl("javascript:" + js);
	}
	
	String readFromFile(String fileName) {
	    StringBuilder s = new StringBuilder();
	    InputStream fIn = null;
	    InputStreamReader isr = null;
	    BufferedReader input = null;
	    try {
	        fIn = assetManager.open(fileName);
	        isr = new InputStreamReader(fIn);
	        input = new BufferedReader(isr);
	        String line = "";
	        while ((line = input.readLine()) != null) {
	            s.append(line);
	        }
	    } catch (Exception e) {
	        e.getMessage();
	    } finally {
	        try {
	            if (isr != null)
	                isr.close();
	            if (fIn != null)
	                fIn.close();
	            if (input != null)
	                input.close();
	        } catch (Exception e2) {
	            e2.getMessage();
	        }
	    }
	    return s.toString();
	}

	public void injectHtmlToWebView() {
		String html = readFromFile(mainHtmlFile);
		Log.i("ActiveInfoView", html);		
		mWebView.loadDataWithBaseURL("file:///android_asset/www/", html, mimeType, encoding, "");
	}
	
}
