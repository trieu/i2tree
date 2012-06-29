package com.i2tree.plugins;

import java.io.File;

import org.apache.cordova.api.Plugin;
import org.apache.cordova.api.PluginResult;
import org.apache.cordova.api.PluginResult.Status;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.content.pm.PackageManager;
import android.net.Uri;
import android.util.Log;
import android.view.View;
import android.widget.Toast;

import com.dropbox.client2.DropboxAPI;
import com.dropbox.client2.android.AndroidAuthSession;
import com.dropbox.client2.android.AuthActivity;
import com.dropbox.client2.session.AccessTokenPair;
import com.dropbox.client2.session.AppKeyPair;
import com.dropbox.client2.session.Session.AccessType;
import com.i2tree.I2treeMainActivity;
import com.i2tree.managers.DropboxApiClientManager;

public class DropboxPlugin extends Plugin {
	

	public final String ACTION_LIST = "listFolder";
	public final String ACTION_LOGIN = "logIn";
	

	@Override
	public PluginResult execute(String action, JSONArray data, String callbackId) {
		Log.d("DropboxPlugin", "Plugin Called");
		PluginResult result = null;
		if (ACTION_LIST.equals(action)) {
			try {
				String fileName = data.getString(0);
				JSONObject fileInfo = listFolder(new File(fileName));
				Log.d("DropboxPlugin", "Returning " + fileInfo.toString());
				result = new PluginResult(Status.OK, fileInfo);
			} catch (JSONException jsonEx) {
				Log.d("DropboxPlugin",
						"Got JSON Exception " + jsonEx.getMessage());
				result = new PluginResult(Status.JSON_EXCEPTION);
			}
		} else if (ACTION_LOGIN.equals(action)) {
			((I2treeMainActivity)this.ctx).login();
			result = new PluginResult(Status.OK);		
		} else {
			result = new PluginResult(Status.INVALID_ACTION);
			Log.d("DirectoryListPlugin", "Invalid action : " + action + " passed");
		}
		return result;
	}

	/**
	 * Gets the Directory listing for file, in JSON format
	 * 
	 * @param file
	 *            The file for which we want to do directory listing
	 * @return JSONObject representation of directory list. e.g
	 *         {"filename":"/sdcard"
	 *         ,"isdir":true,"children":[{"filename":"a.txt"
	 *         ,"isdir":false},{..}]}
	 * @throws JSONException
	 */
	private JSONObject listFolder(File file) throws JSONException {
		JSONObject fileInfo = new JSONObject();
		fileInfo.put("filename", file.getName());
		fileInfo.put("isdir", file.isDirectory());
		if (file.isDirectory()) {
			JSONArray children = new JSONArray();
			fileInfo.put("children", children);
			if (null != file.listFiles()) {
				for (File child : file.listFiles()) {
					children.put(listFolder(child));
				}
			}
		}
		return fileInfo;
	}
	

}