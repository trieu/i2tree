package com.i2tree.browser;

import java.io.IOException;
import java.io.InputStream;
import java.util.Random;

import android.app.Activity;
import android.content.Context;
import android.content.res.AssetManager;
import android.view.Display;
import android.view.WindowManager;
import android.webkit.WebView;

public class LoLView {
	
	AssetManager assetManager;
	WebView mWebView;
	Activity activity;
	LoLPhotosManager loLPhotosManager;
	
//	Random ran = new Random();
//	int r = ran.nextInt(loLPhotosManager.getPhotoNumber()) + 1;
//	loadGaLleryView(r, 6);
	
	public LoLView(Activity activity, WebView mWebView) {
		this.activity = activity;
		this.assetManager = activity.getAssets();
		this.mWebView = mWebView;
		loLPhotosManager = new LoLPhotosManager(activity, mWebView);
		mWebView.addJavascriptInterface(loLPhotosManager, "LoLPhotosManager");
	}

	public void loadHTML(String imgSrc) {
		final String mimeType = "text/html";
		final String encoding = "utf-8";

		InputStream input;
		String html = "";
		try {
			input = assetManager.open("www/main.html");
			int size = input.available();
			byte[] buffer = new byte[size];
			input.read(buffer);
			input.close();

			// byte buffer into a string
			html = new String(buffer);
		} catch (IOException e) {
			e.printStackTrace();
		}

		html = html.replace("{img_src}", imgSrc);

		mWebView.loadDataWithBaseURL("file:///android_asset/www/", html,
				mimeType, encoding, "");
	}
	
	public void loadGaLleryView(int s, int t) {
		final String mimeType = "text/html";
		final String encoding = "utf-8";


		InputStream input;
		String html = "";
		try {
			input = assetManager.open("www/lol_view.html");
			int size = input.available();
			byte[] buffer = new byte[size];
			input.read(buffer);
			input.close();

			// byte buffer into a string
			html = new String(buffer);
		} catch (IOException e) {
			e.printStackTrace();
		}
		String img_nodes = loLPhotosManager.getImageSrcFromCloud(s, t);

		WindowManager wm = (WindowManager) activity.getSystemService(Context.WINDOW_SERVICE);
		Display display = wm.getDefaultDisplay();

		// double img_height = Math.ceil(display.getHeight()/3);
		html = html.replaceAll("_img_height_", "88");
		html = html.replace("{img_nodes}", img_nodes);

		mWebView.loadDataWithBaseURL("file:///android_asset/www/", html,mimeType, encoding, "");
	}

}
