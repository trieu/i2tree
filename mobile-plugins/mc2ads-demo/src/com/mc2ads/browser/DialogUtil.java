package com.mc2ads.browser;


import android.webkit.WebView;

public class DialogUtil {

	public static void showAlert(WebView webView, String msg) {
	
		msg = msg.replace("\"", "'");
		
        String js =
             "javascript: alert(\""+ msg +"\")";
        webView.loadUrl(js);
    }
	
	public static void showLog(WebView webView, String msg) {
		
		msg = msg.replace("\"", "'");
		
        String js =
             "javascript: refreshData(\""+ msg +"\")";
        webView.loadUrl(js);
    }
	
	
}
