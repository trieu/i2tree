package com.i2tree.nodes;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.Date;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.log4j.BasicConfigurator;
import org.apache.log4j.Logger;
import org.eclipse.jetty.server.Request;
import org.eclipse.jetty.server.Server;
import org.eclipse.jetty.server.handler.AbstractHandler;
import org.eclipse.jetty.util.component.LifeCycle;

import com.i2tree.utils.HttpClientUtil;



public class ServiceNodeStarter extends AbstractHandler {
	
	static Logger logger = Logger.getLogger(ServiceNodeStarter.class);
		

	public void handle(String target, Request baseRequest, final HttpServletRequest request, final HttpServletResponse response)
			throws IOException, ServletException {
			
		logger.debug("HTTP Method: " + baseRequest.getMethod() + " ,target: " + target);
		
		response.setCharacterEncoding("UTF-8");
		response.setStatus(HttpServletResponse.SC_OK);
		
		if(target.equals("/favicon.ico")){		
			response.sendRedirect("/resources/images/favicon.ico");
			return;
		} else if (target.startsWith("/resources/")){			
			processTargetResource(target, request, response);			
			return;
		}		
		
		baseRequest.setHandled(true);
		try {
			processTargetHandler(target, request.getQueryString(), request, response);
		} catch (Exception e) {				
			e.printStackTrace();
		}	
		
	}
	
	
	public void initLifeCycleListener() {		
		super.addLifeCycleListener(new Listener() {
			
			@Override
			public void lifeCycleStopping(LifeCycle arg0) {
			}
			
			@Override
			public void lifeCycleStopped(LifeCycle arg0) {
				
			}
			
			@Override
			public void lifeCycleStarting(LifeCycle arg0) {				
				logger.debug("Master Node starting, loading init config ...");
			}
			
			@Override
			public void lifeCycleStarted(LifeCycle arg0) {				
				logger.debug("Master Node Started.");			
			}
			
			@Override
			public void lifeCycleFailure(LifeCycle arg0, Throwable arg1) {
			}
		});
	}
	
	/**
	 * static resource handler 
	 * 
	 * @param target
	 * @param request
	 * @param response
	 * @throws IOException
	 */
	protected void processTargetResource(String target, HttpServletRequest request,HttpServletResponse response) throws IOException {
		
	}


	protected void processTargetHandler(String target, String queryStr, HttpServletRequest request,HttpServletResponse response) {
		logger.info("target: " + target);
		if(request.getParameter("image-file-paths") != null){
			String[] imgFilePaths = request.getParameter("image-file-paths").split(",");  
			final String baseCmd = "java -jar -Xms128m -Xmx1024m -XX:-UseParallelGC make-thumbnail-image.jar ";
			
			for (final String imgFilePath : imgFilePaths) {
				new Thread(new Runnable() {
					@Override
					public void run() {
						try {
							String cmd =  baseCmd + "file://"+ imgFilePath;
							Process child = Runtime.getRuntime().exec(cmd);				

							// hook up child process output to parent
							InputStream lsOut = child.getInputStream();
							InputStreamReader r = new InputStreamReader(lsOut);
							BufferedReader in = new BufferedReader(r);
					
							// read the child process' output
							String line;
							boolean isDone = false;
							while ((line = in.readLine()) != null){
								logger.info(line);	
								if("done".equals(line)){
									isDone = true;
								}
							}	
							
							if(isDone){
								logger.info("imgFilePathOK:" + imgFilePath );
							} else {
								logger.info("imgFilePathFail:" + imgFilePath );
							}
						} 
						catch (Exception e) { // exception thrown
							System.out.println("Command failed!");
						}						
					}
				}).start();				
			}
		}
	}
	
	protected String processStatusData() {
		return "console.log('"+(new Date()).toString() + "'); ";
	}


	public static void main(String[] args) throws Exception {	
		// Set up a simple configuration that logs on the console.
	    BasicConfigurator.configure();
	   	     
		int port = 11000;
		if(args.length == 1){
			try {
				port = Integer.parseInt(args[0]);
			} catch (NumberFormatException e) {}
		}
		String html = HttpClientUtil.executeGet("http://127.0.0.1:"+port);
		if("444".equals(html)){
			Server server = new Server(port);
			ServiceNodeStarter theHandler = new ServiceNodeStarter();
			theHandler.initLifeCycleListener();		
			server.setHandler(theHandler);
			logger.info("Starting Agent Pools at port " + port + " ...");
			logger.info("JVM: " + System.getProperty("sun.arch.data.model") + " bit, version: " + System.getProperty("java.version"));
			server.start();
			server.join();		
		} else {
			System.err.println("\n#### An agent is listening on port "+port + " ####\n");
		}
	}	

}
