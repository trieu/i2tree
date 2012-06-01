package com.i2tree.utils;


import java.awt.image.BufferedImage;
import java.io.BufferedOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.URL;
import java.net.URLConnection;
import java.util.Properties;

import javax.imageio.ImageIO;

public class ScalingImageUtil {
	final static int BUFFER_SIZE = 2048;

	public static String fileUrl(String imageUrl, String localFileName,
			String destinationDir) {
		OutputStream outStream = null;
		URLConnection uCon = null;
		String scaledFilePath = destinationDir + localFileName;
		InputStream is = null;
		try {
			byte[] buf;
			int ByteRead, ByteWritten = 0;
			URL url = new URL(imageUrl);
			outStream = new BufferedOutputStream(new FileOutputStream(
					scaledFilePath));

			uCon = url.openConnection();
			is = uCon.getInputStream();
			buf = new byte[BUFFER_SIZE];
			while ((ByteRead = is.read(buf)) != -1) {
				outStream.write(buf, 0, ByteRead);
				ByteWritten += ByteRead;
			}
			
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			try {
				is.close();
				outStream.close();
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		System.out.println("Processing:" + scaledFilePath);
		return scaledFilePath;
	}

	public static String buildFilenameForSize(String prefix, String fullFilePath, int w,
			int h, String destinationDir) {
		if (fullFilePath == null) {
			throw new IllegalArgumentException(
					"filePath or destinationDir must not NULL");
		}
		fullFilePath = fullFilePath.replace("\\", "/");

		int slashIndex = fullFilePath.lastIndexOf('/');
		int periodIndex = fullFilePath.lastIndexOf('.');

		String fileName = fullFilePath.substring(slashIndex + 1, periodIndex);
		if (periodIndex >= 1 && slashIndex >= 0
				&& slashIndex < fullFilePath.length() - 1) {
			StringBuilder sb = new StringBuilder();
			sb.append(prefix).append("-").append(fileName);
			sb.append("-").append(w).append("x").append(h).append(".")
					.append(fullFilePath.substring(periodIndex + 1));
			return fileUrl(fullFilePath, sb.toString(), destinationDir);
		} else {
			throw new IllegalArgumentException("get file name fail");
		}
	}

	public static String fileDownloadFromURL(String filePath, String destinationDir) {
		if (filePath == null || destinationDir == null) {
			throw new IllegalArgumentException(
					"filePath or destinationDir must not NULL");
		}
		filePath = filePath.replace("\\", "/");

		int slashIndex = filePath.lastIndexOf('/');
		int periodIndex = filePath.lastIndexOf('.');

		String fileName = filePath.substring(slashIndex + 1);
		if (periodIndex >= 1 && slashIndex >= 0
				&& slashIndex < filePath.length() - 1) {
			return fileUrl(filePath, fileName, destinationDir);
		} else {
			System.err.println("path or file name.");
		}
		return "";
	}

	static String THUMB_DIR = "";

	public static String scalingImage(String prefix, String fullPath, int w, int h) {
		try {
			String scaledPath = buildFilenameForSize(prefix, fullPath, w, h, THUMB_DIR);			

			BufferedImage image = ImageIO.read(new File(scaledPath));
			image = ImageUtil.blurImage(image);

			BufferedImage newImage = ImageUtil.scaleImage(image, w, h);
			ImageIO.write(newImage, "JPG", new File(scaledPath));
			image.flush();
			newImage.flush();
			image = null;
			newImage = null;
			return scaledPath;
		} catch (Exception e) {
			e.printStackTrace();
		}
		return fullPath;
	}

	public static long testRackspace(String[] args) {
		if (args.length != 1) {
//			System.err.println("Missing photo Path param!");
//			return;
		}
		Properties properties = new Properties();
		try {
			properties.load(new FileInputStream("image-scaler.properties"));
			THUMB_DIR = properties.getProperty("thumbnail.folder", "");
			String[] sizes = properties.getProperty("thumbnail.sizes", "").split(",");
			//String fileUrl = args[0];		
			String fileUrl = "http://c15060608.r8.cf2.rackcdn.com/d107a6900c0360cb3b62f9c455d05527.jpg";
			String prefix = "";
			long b = System.currentTimeMillis();
			for (String size : sizes) {
				int s = Integer.parseInt(size);
				scalingImage(prefix, fileUrl, s, s);
			}
			long doneTime = System.currentTimeMillis() - b;
			System.out.println("done in " + doneTime );
			return doneTime;
		} catch (Exception e) {
			System.err.println(e.getMessage());
		}
		return 0;
	}
	
	public static long testAmazonAsia(String[] args) {
		if (args.length != 1) {
//			System.err.println("Missing photo Path param!");
//			return;
		}
		Properties properties = new Properties();
		try {
			properties.load(new FileInputStream("image-scaler.properties"));
			THUMB_DIR = properties.getProperty("thumbnail.folder", "");
			String[] sizes = properties.getProperty("thumbnail.sizes", "").split(",");
			//String fileUrl = args[0];			
			//String fileUrl = "http://c15060608.r8.cf2.rackcdn.com/d107a6900c0360cb3b62f9c455d05527.jpg";
			String fileUrl = "http://s3-ap-southeast-1.amazonaws.com/greengar-bucket-asia/d107a6900c0360cb3b62f9c455d05527.jpg";
			String prefix = "";
			long b = System.currentTimeMillis();
			for (String size : sizes) {
				int s = Integer.parseInt(size);
				scalingImage(prefix, fileUrl, s, s);
			}
			long doneTime = System.currentTimeMillis() - b;
			System.out.println("done in " + doneTime );
			return doneTime;
		} catch (Exception e) {
			System.err.println(e.getMessage());
		}
		return 0;
	}
	
	public static long testAmazonUS(String[] args) {
		if (args.length != 1) {
//			System.err.println("Missing photo Path param!");
//			return;
		}
		Properties properties = new Properties();
		try {
			properties.load(new FileInputStream("image-scaler.properties"));
			THUMB_DIR = properties.getProperty("thumbnail.folder", "");
			String[] sizes = properties.getProperty("thumbnail.sizes", "").split(",");
			//String fileUrl = args[0];			
			//String fileUrl = "http://c15060608.r8.cf2.rackcdn.com/d107a6900c0360cb3b62f9c455d05527.jpg";
			String fileUrl = "http://s3.amazonaws.com/greengar-bucket-us/d107a6900c0360cb3b62f9c455d05527.jpg";
			String prefix = "";
			long b = System.currentTimeMillis();
			for (String size : sizes) {
				int s = Integer.parseInt(size);
				scalingImage(prefix, fileUrl, s, s);
			}
			long doneTime = System.currentTimeMillis() - b;
			System.out.println("done in " + doneTime );
			return doneTime;
		} catch (Exception e) {
			System.err.println(e.getMessage());
		}
		return 0;
	}
	
	static int numTest = 10;
	static long[] amazonTimesUS = new long[numTest];
	static long[] amazonTimesAsia = new long[numTest];
	static long[] rackspaceTimes = new long[numTest];
	public static void main(String[] args) {
		for(int i=0; i < numTest; i++){
			amazonTimesUS[i] = testAmazonUS(args);
			amazonTimesAsia[i] = testAmazonAsia(args);
			rackspaceTimes[i] = testRackspace(args);
		}
		long totalAmazonUS = 0;
		for (int i = 0; i < amazonTimesUS.length; i++) {
			totalAmazonUS += amazonTimesUS[i];
		}
		System.out.println("AmazonUS  AVG: " + Math.ceil(totalAmazonUS / amazonTimesUS.length) / 1000 );
		
		long totalAmazonAsia = 0;
		for (int i = 0; i < amazonTimesAsia.length; i++) {
			totalAmazonAsia += amazonTimesAsia[i];
		}
		System.out.println("AmazonAsia AVG: " + Math.ceil(totalAmazonAsia / amazonTimesAsia.length) / 1000 );
		
		long totalRackspace = 0;
		for (int i = 0; i < rackspaceTimes.length; i++) {
			totalRackspace += rackspaceTimes[i];
		}
		System.out.println("Rackspace AVG: " + Math.ceil(totalRackspace / rackspaceTimes.length) / 1000);
	}
}