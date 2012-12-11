package com.i2tree.browser;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.Formatter;

public class StringUtil {

	public static String sha1(byte[] convertme) {
	    MessageDigest md;
		try {
			md = MessageDigest.getInstance("SHA-1");
			return byteArray2Hex(md.digest(convertme));
		} catch (NoSuchAlgorithmException e) {		
			e.printStackTrace();
		} 
	    return "";
	}
	
	private static String byteArray2Hex(final byte[] hash) {
	    Formatter formatter = new Formatter();
	    for (byte b : hash) {
	        formatter.format("%02x", b);
	    }
	    return formatter.toString();
	}
}
