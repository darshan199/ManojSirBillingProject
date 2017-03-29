<?php

class DatabaseConnection 
{
	
	public static function connect($database)
	{
		 
		try {
			    return new PDO('mysql:host=localhost;dbname='.$database, 'root', '');
		} 
		catch (PDOException $e) {
			    print "Error!: " . $e->getMessage() . "<br/>";
			    die();
		}

	}
}