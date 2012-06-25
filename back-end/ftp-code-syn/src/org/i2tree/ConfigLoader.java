package org.i2tree;

import java.io.FileInputStream;
import java.io.IOException;
import java.util.Properties;

/**
 *
 * @author trieu
 */
public class ConfigLoader {

    String host;
    String typeChannel;
    String username;
    String password;
    int port;
    String baseLocal;
    String baseRemote;

    public String getHost() {
        return host;
    }

    public void setHost(String host) {
        this.host = host;
    }

    public String getTypeChannel() {
        return typeChannel;
    }

    public void setTypeChannel(String typeChannel) {
        this.typeChannel = typeChannel;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public int getPort() {
        return port;
    }

    public void setPort(int port) {
        this.port = port;
    }

    public String getBaseLocal() {
        return baseLocal;
    }

    public void setBaseLocal(String baseLocal) {
        this.baseLocal = baseLocal;
    }

    public String getBaseRemote() {
        return baseRemote;
    }

    public void setBaseRemote(String baseRemote) {
        this.baseRemote = baseRemote;
    }
    
    

    public static ConfigLoader init(String filename) {
        ConfigLoader configLoader = new ConfigLoader();


        Properties prop = new Properties();


        try {
            prop.load(new FileInputStream(filename));
            
            configLoader.setHost(prop.getProperty("host"));
            configLoader.setUsername(prop.getProperty("username"));
            configLoader.setPort( Integer.parseInt(prop.getProperty("port")) );
            configLoader.setPassword(prop.getProperty("password"));
            configLoader.setTypeChannel(prop.getProperty("type_channel"));
            
            configLoader.setBaseLocal(prop.getProperty("base_local"));
            configLoader.setBaseRemote(prop.getProperty("base_remote"));

        } catch (IOException ex) {
            ex.printStackTrace();
        }

        
        return configLoader;
    }

//    public static void main(String[] args) {
//        //
//        ConfigLoader cl = ConfigLoader.init("test-server-greengar.properties");
//        System.out.println(cl.getHost());
//        System.out.println(cl.getUsername());
//        System.out.println(cl.getPassword());
//        System.out.println(cl.getTypeChannel());
//        System.out.println(cl.getPort());
//        System.out.println(cl.getBaseLocal());
//        System.out.println(cl.getBaseRemote());
//    }
}
