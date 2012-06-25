package org.i2tree;


import com.jcraft.jsch.SftpProgressMonitor;

/**
 *
 * @author trieu
 */
public class UploadProgressMonitor implements SftpProgressMonitor {

    long max = 0;
    String src, dest;
    boolean done = false;

    @Override
    public void init(int op, String src, String dest, long max) {
        this.max = max;
        this.src = src;
        this.dest = dest;
    }

    @Override
    public boolean count(long count) {
        if (this.max > 0 && count > 0) {
            double p = Math.floor((count * 100) / this.max);
           // System.out.println(count + " p: " + p);
            return true;
        }
        return false;
    }

    @Override
    public void end() {
        System.out.println("Done from src: " + src + " to dest: " + dest);
        this.done = true;
    }

    public boolean isDone() {
        return done;
    }
    
    
}
