package com.mc2ads.browser;


import android.content.Intent;
import android.net.Uri;
import android.util.Log;
import android.webkit.WebView;
import android.webkit.WebViewClient;

public class Mc2AdsWebViewClient extends WebViewClient {
	
	static final String fbLoginHint = "www.facebook.com/dialog/permissions.request";
	static final String upload = "nguyentantrieu.info/mads/upload.php";
	//static final String upload = "10.0.2.2 /mads/upload.php";
	
	static final String authHint = "www.facebook.com/dialog/oauth";
	
	ActiveInfoView activeInfoView;
	
	public ActiveInfoView getActiveInfoView() {
		return activeInfoView;
	}

	public void setActiveInfoView(ActiveInfoView activeInfoView) {
		this.activeInfoView = activeInfoView;
	}

	@Override
	public void onPageFinished(WebView view, String url) {
		//view.loadUrl("javascript:alert('hi')");
		Log.i("I2treeWebViewClient onPageFinished url: ", url);
		if(url.contains(fbLoginHint) || url.contains(upload)  ){
			activeInfoView.loadHTML();
		}
	}
	
	@Override
	public boolean shouldOverrideUrlLoading(WebView view, String url){
        // do your handling codes here, which url is the requested url
        // probably you need to open that url rather than redirect:
		Log.i("I2treeWebViewClient shouldOverrideUrlLoading url: ", url);
		if(url.startsWith("http")){
			Uri uri = Uri.parse(url);
			Intent intent = new Intent(Intent.ACTION_VIEW, uri);
			activeInfoView.getActivity().startActivity(intent);
			return true;
		}
		if(url.contains(authHint) )	{
			activeInfoView.loadHTML();
			return false;
		}
        view.loadUrl(url);
        return true; // then it is not handled by default action
   }

}
