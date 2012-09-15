package com.i2tree.browser;

import android.content.Context;
import android.widget.Toast;

public class GSLog {

	Context mContext;

	/** Instantiate the interface and set the context */
	public GSLog(Context c) {
		mContext = c;
	}

	/** Show a toast from the web page */
	public void showToast(String toast) {
		Toast.makeText(mContext, toast, Toast.LENGTH_SHORT).show();
	}
	
	public void i(String s){
		android.util.Log.i("Webview", s);
	}

}
