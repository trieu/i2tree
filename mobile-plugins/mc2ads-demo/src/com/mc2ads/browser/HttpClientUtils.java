package com.mc2ads.browser;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.conn.ClientConnectionManager;
import org.apache.http.conn.scheme.PlainSocketFactory;
import org.apache.http.conn.scheme.Scheme;
import org.apache.http.conn.scheme.SchemeRegistry;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.impl.conn.tsccm.ThreadSafeClientConnManager;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpParams;
import org.apache.http.protocol.HTTP;
import org.apache.http.util.EntityUtils;

import android.util.Log;

public class HttpClientUtils {
	
	public static final HttpClient theThreadSafeHttpClient() {
		HttpParams params = new BasicHttpParams();
	    SchemeRegistry registry = new SchemeRegistry();
	    registry.register(new Scheme("http", PlainSocketFactory.getSocketFactory(), 80));
	    ClientConnectionManager cm = new ThreadSafeClientConnManager(params, registry);
	    HttpClient client = new DefaultHttpClient(cm, params);
	    return client;
	}
	
	public static final String USER_AGENT = "Mozilla/5.0 (Windows NT 5.1; rv:9.0) Gecko/20100101 Firefox/9.0";
	public static String executeGet(String url){
		HttpResponse response = null;
		HttpClient httpClient = null;
		try {
			HttpGet httpget = new HttpGet(url);			
			httpget.setHeader("User-Agent", USER_AGENT);
			httpget.setHeader("Accept-Charset", "utf-8");
			httpget.setHeader("Accept", "text/html,application/xhtml+xml");
			httpget.setHeader("Cache-Control", "max-age=3, must-revalidate, private");	
			//httpget.setHeader("Authorization", "OAuth oauth_token=223a363ea1fd0a13b44e52663b97a255, oauth_consumer_key=a324957217164fd1d76b4b60d037abec, oauth_version=1.0, oauth_signature_method=HMAC-SHA1, oauth_timestamp=1322049404, oauth_nonce=-5195915877644743836, oauth_signature=wggOr1ia7juVbG%2FZ2ydImmiC%2Ft4%3D");
			
			httpClient = theThreadSafeHttpClient();
			response = httpClient.execute(httpget);
			
			int code = response.getStatusLine().getStatusCode();
			if (code == 200) {				
				HttpEntity entity = response.getEntity();
				if (entity != null) {										
					String html = EntityUtils.toString(entity, HTTP.UTF_8);
					return html;
				}
			} else if(code == 404) {
				return "404";
			} else {
				return "500";
			}
		}  catch (Throwable e) {
			if( e instanceof java.net.ConnectException){
				return "444";
			} 
			Log.e("WebViewActivity", e.getMessage());
		} finally {
			if(httpClient != null) {
				httpClient.getConnectionManager().closeExpiredConnections();
				httpClient = null;
			}
			response = null;
		}
		return "";
	}
}
