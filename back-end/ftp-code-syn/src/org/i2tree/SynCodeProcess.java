package org.i2tree;

import com.jcraft.jsch.*;
import java.util.Queue;
import java.util.Vector;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

public class SynCodeProcess {

    private static final int NTHREDS = 7;
    static ConfigLoader cl = ConfigLoader.init("test-server-greengar.properties");

    public static void main(String args[]) {


        JSch jsch = new JSch();
        Session session = null;
        try {
            session = jsch.getSession(cl.getUsername(), cl.getHost(), cl.getPort());
            session.setPassword(cl.getPassword());
            session.setConfig("StrictHostKeyChecking", "no");
            session.connect();


            ExecutorService executor = Executors.newFixedThreadPool(NTHREDS);

            synCodeToRemoteHost(executor, cl.getBaseLocal(), cl.getBaseRemote(), session);

            executor.shutdown();
            while (!executor.isTerminated()) {
                Thread.sleep(500);
            }
            //Finished all threads

            session.disconnect();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    static void synCodeToRemoteHost(ExecutorService executor, final String baseLocal, final String baseRemote, final Session session) throws SftpException {
        final Queue<String> localPaths = Filewalker.initQueueUploadedFiles(baseLocal);
        int size = localPaths.size();
        System.out.println("Poll queue, check Size: " + size);
        
        String localPath = localPaths.poll();
        
        while (localPath != null) {
            final String safeLocalPath = localPath.replace("\\", "/");
            //System.out.println(localPath);
            final String remotePath = safeLocalPath.replace(baseLocal, baseRemote);
            //System.out.println(remotePath);

            executor.execute(new Runnable() {
                @Override
                public void run() {
                    try {

                        Channel channel = session.openChannel(cl.getTypeChannel());
                        channel.connect();
                        ChannelSftp sftpChannel = (ChannelSftp) channel;

                        UploadProgressMonitor monitor = new UploadProgressMonitor();

                        sftpChannel.put(safeLocalPath, remotePath, monitor);


                        sftpChannel.exit();
                    } catch (Exception e) {
                        System.err.println(e);
                    }
                }
            });

            
            System.out.println("Poll queue, check Size: " + localPaths.size());
            localPath = localPaths.poll();
        }
    }

    static void listFolder(ChannelSftp sftpChannel) throws SftpException {
        Vector<ChannelSftp.LsEntry> list = sftpChannel.ls("/var/www/*.php");
        for (ChannelSftp.LsEntry e : list) {
            String s = e.getLongname().replaceAll("\\s+", " ");
            System.out.println(s);
        }
    }
}