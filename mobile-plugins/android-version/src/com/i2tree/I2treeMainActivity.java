package com.i2tree;

import org.apache.cordova.DroidGap;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;

import com.i2tree.managers.DropboxApiClientManager;

public class I2treeMainActivity extends DroidGap
{
	
	DropboxApiClientManager dropboxApiClientManager;
	
    @Override
    public void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        dropboxApiClientManager = DropboxApiClientManager.theInstance(this);
        
        super.loadUrl("file:///android_asset/www/index2.html");
        
    }
    
    public void login(){
    	dropboxApiClientManager.getmApi();
    }
    
    @Override
    protected void onSaveInstanceState(Bundle outState) {
       // outState.putString("mCameraFileName", mCameraFileName);
        super.onSaveInstanceState(outState);
    }

    @Override
    protected void onResume() {
        super.onResume();
        
        dropboxApiClientManager.onResumeHandler();

    }

    // This is what gets called on finishing a media piece to import
    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
    	
    	dropboxApiClientManager.onActivityResultHandler(requestCode, resultCode, data);

    }
}