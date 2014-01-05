package com.comze_instancelabs.drakonnassystem;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.URL;
import java.net.URLConnection;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.List;

import org.bukkit.Bukkit;
import org.bukkit.Location;
import org.bukkit.command.Command;
import org.bukkit.command.CommandSender;
import org.bukkit.entity.Player;
import org.bukkit.event.EventHandler;
import org.bukkit.event.Listener;
import org.bukkit.event.player.PlayerCommandPreprocessEvent;
import org.bukkit.event.player.PlayerJoinEvent;
import org.bukkit.event.player.PlayerQuitEvent;
import org.bukkit.event.server.ServerCommandEvent;
import org.bukkit.plugin.java.JavaPlugin;

public class Main extends JavaPlugin implements Listener{

	public static HashMap<String, Integer> ppoints = new HashMap<String, Integer>();
	public static HashMap<String, Integer> ptime = new HashMap<String, Integer>();
	public static HashMap<String, Long> pjoined = new HashMap<String, Long>();
	
	public boolean debug = true;
	public int minutes = 10;
	
	public static String host = "127.0.0.1";
	public static String username = "root";
	public static String password = "";
	public static String database = "drakonnas";
	
	@Override
	public void onEnable(){
		getServer().getPluginManager().registerEvents(this, this);
		
		Bukkit.getServer().getScheduler().scheduleSyncDelayedTask(this, new Runnable(){
			@Override
			public void run(){
				try{
					syncGet();
					for(Player p : Bukkit.getOnlinePlayers()){
						pjoined.put(p.getName(), System.currentTimeMillis());
					}
				}catch(Exception e){
					
				}
			}
		}, 5);
		
		Bukkit.getServer().getScheduler().scheduleSyncRepeatingTask(this, new Runnable(){
			@Override
			public void run() {
				syncSaveAll();
			}
		}, 20 * 60 * minutes, 20 * 60 * minutes);
	}
	
	@Override
	public void onDisable(){
		syncSaveAll();
	}
	
    public boolean onCommand(CommandSender sender, Command cmd, String label, String[] args){
    	if(cmd.getName().equalsIgnoreCase("register")){
    		if(args.length > 1){
    			String email = args[0];
    			String password = args[1];
    			//TODO: register code
    		}
    		return true;
    	}else if(cmd.getName().equalsIgnoreCase("addpoints")){
    		if(sender.hasPermission("drakonnassystem.addpoints")){
	    		if(args.length > 1){ // /addpoints name amount
	    			String name = args[0];
	    			String amount = args[1];
	    			if(isNumeric(amount)){
	    				addPoints(name, amount);
	    				sender.sendMessage("§2Points added.");
	    			}else{
	    				sender.sendMessage("§3Usage: §6/addpoints name amount");
	    			}
	    		}else{
	    			sender.sendMessage("§3Usage: §6/addpoints name amount");
	    		}
    		}
    		return true;
    	}else if(cmd.getName().equalsIgnoreCase("removepoints")){
    		if(sender.hasPermission("drakonnassystem.removepoints")){
	    		if(args.length > 1){ // /removepoints name amount
	    			String name = args[0];
	    			String amount = args[1];
	    			if(isNumeric(amount)){
	    				removePoints(name, amount);
	    				sender.sendMessage("§4Points removed.");
	    			}else{
	    				sender.sendMessage("§3Usage: §6/removepoints name amount");
	    			}
	    		}else{
	    			sender.sendMessage("§3Usage: §6/removepoints name amount");
	    		}
    		}
    		return true;
    	}else if(cmd.getName().equalsIgnoreCase("pointstop")){
    		//if(sender.hasPermission("drakonnassystem.pointstop")){
	    		sender.sendMessage("§3Top 10 Players: ");
	    		HashMap<String, Integer> top = MySQLGetTopPoints();
	    		for(String p : top.keySet()){
	    			sender.sendMessage("§6" + p + "§2 - §6" + Integer.toString(top.get(p)));
	    		}
    		//}
    		return true;
    	}else if(cmd.getName().equalsIgnoreCase("points")){
    		//if(sender.hasPermission("drakonnassystem.points")){
	    		if(args.length > 0){ // /points name
	    			if(ppoints.containsKey(args[0])){
	    				sender.sendMessage("§3The player §6" + args[0] + " §3has §6" + Integer.toString(ppoints.get(args[0])) + " points.");
	    			}else{
	    				sender.sendMessage("§4Player could not be found.");
	    			}
	    		}else{
	    			sender.sendMessage("§3Usage: §6/points name");
	    		}
    		//}
    		
    		return true;
    	}
    	return false;
    }
	
	
	@EventHandler
	public void onPlayerJoin(PlayerJoinEvent event){
		pjoined.put(event.getPlayer().getName(), System.currentTimeMillis());
		if(ptime.containsKey(event.getPlayer().getName()) && ppoints.containsKey(event.getPlayer().getName())){
			this.MySQLSavePlayerData(event.getPlayer().getName(), 1);
		}else{
			ptime.put(event.getPlayer().getName(), 0);
			ppoints.put(event.getPlayer().getName(), 0);
			this.MySQLSavePlayerData(event.getPlayer().getName(), 1);
		}
	}
	
	@EventHandler
	public void onPlayerLeave(PlayerQuitEvent event){
		Player p = event.getPlayer();
		ptime.put(p.getName(), ptime.get(p.getName()) + getTimeSpan(pjoined.get(p.getName())));
		pjoined.remove(p.getName());
		this.MySQLSavePlayerData(p.getName(), 0);
	}

	@EventHandler
	public void onServerCommand(ServerCommandEvent event){
		// assuming it's always /ban [player]
		if(event.getCommand().contains("ban")){
			try{
				banPlayer(event.getCommand().split(" ")[1]);
			}catch(Exception e){
				
			}
		}
	}
	
	@EventHandler
	public void onPlayerCommandPreprocess(PlayerCommandPreprocessEvent event){
		// assuming it's always /ban [player]
		if(event.getMessage().contains("ban")){
			try{
				banPlayer(event.getMessage().split(" ")[1]);
			}catch(Exception e){
				
			}
		}
	}
	
	public void banPlayer(String player) throws IOException{
		this.MySQLSavePlayerData(player, 0, 1);
	}
	
	
	public void syncSaveAll(){
		for(Player p : Bukkit.getOnlinePlayers()){
			try{
				// save new timespent value
				ptime.put(p.getName(), ptime.get(p.getName()) + getTimeSpan(pjoined.get(p.getName())));
				// reset pjoined again
				pjoined.put(p.getName(), System.currentTimeMillis());
				MySQLSavePlayerData(p.getName(), 1);
			}catch(Exception e){
				
			}
		}
	}
	
	public void syncGet() throws IOException{
		MySQL MySQL = new MySQL(host, "3306", database, username, password);
    	Connection c = null;
    	c = MySQL.open();
		
		//insert into players, if doesn't exist yet
		try {
			ResultSet res3 = c.createStatement().executeQuery("SELECT * FROM players");
			while (res3.next()) {
			    int points = res3.getInt("points");
			    int timespent = res3.getInt("timespent");
			    String player = res3.getString("player");
			    ppoints.put(player, points);
			    ptime.put(player, timespent);
			}
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}
	
	
	public void MySQLSavePlayerData(String p_, int online, int banned){
		MySQL MySQL = new MySQL(host, "3306", database, username, password);
    	Connection c = null;
    	c = MySQL.open();
		
		//insert into players, if doesn't exist yet
		try {
			ResultSet res3 = c.createStatement().executeQuery("SELECT id FROM players WHERE player='" + p_ + "'");
			if(!res3.isBeforeFirst()){
				// there's no such user
				c.createStatement().executeUpdate("INSERT INTO players(id, uuid, player, rank, banned, timespent, points, online, email, password, registerkey) VALUES('0', '', '" + p_ + "', '', '" + banned + "', '" + Integer.toString(ptime.get(p_)) + "', '" + Integer.toString(ppoints.get(p_)) + "', '" + Integer.toString(online) +"', '', '', '')");
			}else{
				c.createStatement().executeUpdate("UPDATE players SET timespent=" + Integer.toString(ptime.get(p_)) + ", banned=" + Integer.toString(banned) + ", online=" + Integer.toString(online) + ", points=" + Integer.toString(ppoints.get(p_)) + " WHERE player='" + p_ + "' ");
			}
		} catch (Exception e) {
			e.printStackTrace();
			
			for(StackTraceElement st : e.getStackTrace()){
				System.out.println(st);
			}
			
			try {
				c.createStatement().executeUpdate("INSERT INTO players(id, uuid, player, rank, banned, timespent, points, online, email, password, registerkey) VALUES('0', '', '" + p_ + "', '', '" + banned + "', '" + Integer.toString(ptime.get(p_)) + "', '" + Integer.toString(ppoints.get(p_)) + "', '" + Integer.toString(online) +"', '', '', '')");
			} catch (SQLException e1) {
				e1.printStackTrace();
				for(StackTraceElement st : e1.getStackTrace()){
					System.out.println(st);
				}
			}
		}
	}
	
	public void MySQLSavePlayerData(String p_, int online){
		int banned = 0;
		
		MySQLSavePlayerData(p_, online, 0);
	}

	public static boolean MySQLUpdatePlayerData(String p_){
		MySQL MySQL = new MySQL(host, "3306", database, username, password);
    	Connection c = null;
    	c = MySQL.open();
		
		//insert into players, if doesn't exist yet
		try {
			ResultSet res3 = c.createStatement().executeQuery("SELECT id FROM players WHERE player='" + p_ + "'");
			if(!res3.isBeforeFirst()){
				// there's no such user -> noone to update
				return false;
			}else{
				c.createStatement().executeUpdate("UPDATE players SET timespent=" + Integer.toString(ptime.get(p_)) + ", points=" + Integer.toString(ppoints.get(p_)) + " WHERE player='" + p_ + "' ");
			}
		} catch (Exception e) {
			e.printStackTrace();
			return false;
		}
		return true;
	}
	
	public HashMap<String,Integer> MySQLGetTopPoints(){
		HashMap<String, Integer> ret = new HashMap<String, Integer>();
		
		MySQL MySQL = new MySQL(host, "3306", database, username, password);
    	Connection c = null;
    	c = MySQL.open();

		try {
			ResultSet res3 = c.createStatement().executeQuery("SELECT * FROM players ORDER BY points DESC LIMIT 10");
			while (res3.next()) {
	            String player = res3.getString("player");
	            int points = res3.getInt("points");
	            ret.put(player, points);
	        }
		} catch (Exception e) {
			e.printStackTrace();
		}
		
		return ret;
	}
	

	
	public static Integer getTimeSpan(long i) {
		// date of now:
		Calendar cal = Calendar.getInstance();
		cal.setTimeInMillis(System.currentTimeMillis());
		Date date2 = cal.getTime();
		// date of join date:
		Calendar cal_ = Calendar.getInstance();
		cal_.setTimeInMillis(Long.valueOf(i));
		Date date1 = cal_.getTime();
		return secondsBetween(cal_.getTime(),cal.getTime());
	}
	
	public static int secondsBetween(Date d1, Date d2){
		long differenceMilliSeconds = d2.getTime() - d1.getTime();
		//long days = differenceMilliSeconds / 1000 / 60 / 60 / 24;
		long seconds = differenceMilliSeconds / 1000;
		return (int) seconds;
	}
	
	
	public static boolean isNumeric(String str) {
		try {
			double d = Double.parseDouble(str);
		} catch (NumberFormatException nfe) {
			return false;
		}
		return true;
	}
	
	
	
	// API for other plugins to hook into
	
	public static boolean addPoints(String name, String amount){
		ppoints.put(name, ppoints.get(name) + Integer.parseInt(amount));
		if(!MySQLUpdatePlayerData(name)){
			return false;
		}
		return true;
	}
	
	public static boolean removePoints(String name, String amount){
		if(ppoints.get(name) - Integer.parseInt(amount) < 0){
			ppoints.put(name, 0);
		}else{
			ppoints.put(name, ppoints.get(name) - Integer.parseInt(amount));
		}
		if(!MySQLUpdatePlayerData(name)){
			return false;
		}
		return true;
	}
	
	public static Integer getPoints(String name){
		return ppoints.get(name);
	}
	
	public void processPendingTransactions(){
		MySQL MySQL = new MySQL(host, "3306", database, username, password);
    	Connection c = null;
    	c = MySQL.open();
		
		//get all transactions, execute them and clear the table afterwards
		try {
			ResultSet res3 = c.createStatement().executeQuery("SELECT * FROM item_transactions");
			while (res3.next()) {
			    String cmd = res3.getString("command");
			    Bukkit.dispatchCommand(Bukkit.getConsoleSender(), cmd);
			}
			c.createStatement().executeQuery("DELETE FROM item_transactions");
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}

}
