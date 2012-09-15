package com.i2tree.browser;

import android.app.Activity;
import android.media.MediaPlayer;
import android.provider.Settings;

public class SoundUtil {
	public static void makeDefaultNotificationSound(final Activity activity, final int times){
		
			new Thread(new Runnable() {				
				public void run() {
					for (int i = 0; i < times; i++) {
						MediaPlayer.create(activity, Settings.System.DEFAULT_NOTIFICATION_URI).start();
						try {
							Thread.sleep(1000);
						} catch (InterruptedException e) {}
					}		
				}
			}).start();
			
		
	}
}
