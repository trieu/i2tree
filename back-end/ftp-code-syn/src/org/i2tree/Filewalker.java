package org.i2tree;

import java.io.File;
import java.util.PriorityQueue;
import java.util.Queue;
import java.util.concurrent.ConcurrentLinkedQueue;

/**
 *
 * @author trieu
 */
public class Filewalker {

    Queue<String> queueUploadedFiles = new ConcurrentLinkedQueue<>();

    public Queue<String> getQueueUploadedFiles() {
        return queueUploadedFiles;
    }

    public void walk(String path) {

        File root = new File(path);
        File[] list = root.listFiles();

        for (File f : list) {
            String name = f.getName();
            String fullpath = f.getAbsolutePath();
            if (!name.equals(".svn") && !name.equals(".DS_Store")) {
                if (f.isDirectory()) {
                    walk(f.getAbsolutePath());
                    // System.out.println("Dir:" + fullpath);
                } else {
                    queueUploadedFiles.add(fullpath);
                    // System.out.println("File:" + fullpath);
                }
            }
        }
    }

    public static Queue<String> initQueueUploadedFiles(String path) {
        Filewalker fw = new Filewalker();
        String base = "d:\\xampp/htdocs/usersystem2/";
        //fw.walk(base + "mod/greengar");
        fw.walk(path);
        return fw.getQueueUploadedFiles();
    }
}
