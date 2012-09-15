package com.i2tree.browser;

import java.math.BigInteger;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.Formatter;



public class StringUtil {
	
	
	public static boolean isStringContain(String text, String words){
		//Pattern p = Pattern.compile("YOUR_REGEX", Pattern.CASE_INSENSITIVE | Pattern.UNICODE_CASE);
		//p.m
		return text.matches("(?i)(.*)"+words+"(.*)");
	}
	
	private static String byteArray2Hex(final byte[] hash) {
	    Formatter formatter = new Formatter();
	    for (byte b : hash) {
	        formatter.format("%02x", b);
	    }
	    String s = formatter.toString();
	    formatter.close();
	    return s;
	}
	
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
	
	public static String sha256(String s){
		MessageDigest digest=null;
	    try {
	        digest = MessageDigest.getInstance("SHA-256");
	    } catch (NoSuchAlgorithmException e1) {
	        // TODO Auto-generated catch block
	        e1.printStackTrace();
	    }
	    digest.reset();
	    byte[] data = digest.digest(s.getBytes());
		return String.format("%0" + (data.length * 2) + 'x', new BigInteger(1, data));			
	}

	
	
	public static void main1(String[] args) {
		
		String text = "Ngày 9/3, Phó chủ tịch Hà Nội Nguyễn Văn Khôi chỉ đạo Sở Giao thông Vận tải tăng thêm các tuyến phố cấm đỗ xe, trình thành phố trong tháng 4.> Ngư�?i dân chật vật tìm chỗ gửi xe>'Hà Nội chưa quan tâm đầu tư bãi đỗ xe'";
		System.out.println(isStringContain(text, "ha Nội"));
		
		String hex = Integer.toHexString(2000000184);
		StringBuilder sb = new StringBuilder();
		int l = hex.length();
		for(int i= 0; i < l; i++){
			sb.append(hex.charAt(i));			
			if(i>0 && ((i+1) % 2 == 0)){
				sb.append("/");
			}			
		}
		
		String url ="/Files/Subject/" + sb.toString() +"12_12_Cliton.jpg";
		System.out.println(url);
	}
	


	public static String replace(String value, String returnNewLine, String newLine) {
		if(value == null) return "";
		return value.replace(returnNewLine, newLine);
	}
}
