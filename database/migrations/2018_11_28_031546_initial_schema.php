<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class InitialSchema extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement( "
  		  CREATE TABLE `Status` (
            `ID_Status` tinyint(4) NOT NULL AUTO_INCREMENT,
            `Name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`ID_Status`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        " );

		DB::statement( "
          CREATE TABLE `Photo` (
            `ID_Photo` int(32) NOT NULL AUTO_INCREMENT,
            `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `CreateDateTime` datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`ID_Photo`),
            UNIQUE KEY `url_UNIQUE` (`url`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        " );

		DB::statement( "
          CREATE TABLE `User` (
            `ID_User` int(32) NOT NULL AUTO_INCREMENT,
            `Role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `FirstName` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `LastName` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `Email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `Phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `Password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `ParentID` int(32) DEFAULT NULL,
            `CreateDateTime` datetime DEFAULT CURRENT_TIMESTAMP,
            `PostalCode` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `PhotoConsent` bit(1) DEFAULT NULL,
            PRIMARY KEY (`ID_User`),
            KEY `ID_User` (`ID_User`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        " );

		DB::statement( "
          CREATE TABLE `UserPhoto` (
            `ID_UserPhoto` int(11) NOT NULL,
            `ID_User` int(11) DEFAULT NULL,
            `ID_Photo` int(11) DEFAULT NULL,
            `CreateDateTime` datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`ID_UserPhoto`),
            KEY `fk_UserPhoto_User_idx` (`ID_User`),
            KEY `fk_UserPhoto_Photo_idx` (`ID_Photo`),
            CONSTRAINT `fk_UserPhoto_Photo` FOREIGN KEY (`ID_Photo`) REFERENCES `Photo` (`ID_Photo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `fk_UserPhoto_User` FOREIGN KEY (`ID_User`) REFERENCES `User` (`ID_User`) ON DELETE NO ACTION ON UPDATE NO ACTION
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        " );

		DB::statement( "
          CREATE TABLE `Accessory` (
            `ID_Accessory` int(32) NOT NULL AUTO_INCREMENT,
            `ID_Type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
            `ID_Status` tinyint(4) DEFAULT NULL,
            `Name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
            `Description` longtext COLLATE utf8mb4_unicode_ci,
            `CreateDateTime` datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`ID_Accessory`),
            KEY `fk_Accessory_Status` (`ID_Status`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        " );

		DB::statement( "
          CREATE TABLE `AccessoryHistory` (
            `ID_AccHistory` int(32) NOT NULL AUTO_INCREMENT,
            `ID_Assce` int(32) NOT NULL,
            `ID_BikeHistory` int(32) NOT NULL,
            `Note` longtext COLLATE utf8mb4_unicode_ci,
            PRIMARY KEY (`ID_AccHistory`),
            KEY `fk_AccessoryHistory_Accessory_idx` (`ID_Assce`),
            CONSTRAINT `fk_AccessoryHistory_Accessory` FOREIGN KEY (`ID_Assce`) REFERENCES `Accessory` (`ID_Accessory`) ON DELETE NO ACTION ON UPDATE NO ACTION
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        " );

		DB::statement( "
          CREATE TABLE `AccessoryType` (
            `ID_AccessoryType` int(32) NOT NULL AUTO_INCREMENT,
            `Type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`ID_AccessoryType`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        " );

		DB::statement( "
          CREATE TABLE `Bike` (
            `ID_Bike` int(11) NOT NULL AUTO_INCREMENT,
            `ID_Status` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
            `BikeLabel` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
            `SerialNumber` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
            `Description` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `GearCount` int(11) DEFAULT NULL,
            `TireMaxPSI` int(11) DEFAULT NULL,
            `TireSize` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `Color` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `Class` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `Brand` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `BellHorn` bit(1) DEFAULT NULL,
            `Reflectors` bit(1) DEFAULT NULL,
            `Lights` bit(1) DEFAULT NULL,
            `LastStatusChanged` datetime DEFAULT NULL,
            PRIMARY KEY (`ID_Bike`),
            UNIQUE KEY `Label_UNIQUE` (`BikeLabel`),
            UNIQUE KEY `Serial_UNIQUE` (`SerialNumber`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        " );

		DB::statement( "
          CREATE TABLE `BikeHistory` (
            `ID_BikeHistory` int(11) NOT NULL AUTO_INCREMENT,
            `ID_Bike` int(11) DEFAULT NULL,
            `ID_BikeUser` int(11) DEFAULT NULL,
            `ID_StaffUser` int(11) DEFAULT NULL,
            `CreateDateTime` datetime DEFAULT NULL,
            `LoanDateTime` datetime DEFAULT NULL,
            `DueDateTime` datetime DEFAULT NULL,
            `ReturnDateTime` datetime DEFAULT NULL,
            `Notes` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `ID_Status` tinyint(4) NOT NULL,
            PRIMARY KEY (`ID_BikeHistory`),
            KEY `fk_BikeHistory_BikeUser_idx` (`ID_BikeUser`),
            KEY `fk_BikeHistory_StaffUser_idx` (`ID_StaffUser`),
            KEY `fk_BikeHistory_Status` (`ID_Status`),
            KEY `fk_BikeHistory_Bike_idx` (`ID_Bike`),
            CONSTRAINT `fk_BikeHistory_Bike` FOREIGN KEY (`ID_Bike`) REFERENCES `Bike` (`ID_Bike`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `fk_BikeHistory_BikeUser` FOREIGN KEY (`ID_BikeUser`) REFERENCES `User` (`ID_User`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `fk_BikeHistory_StaffUser` FOREIGN KEY (`ID_StaffUser`) REFERENCES `User` (`ID_User`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `fk_BikeHistory_Status` FOREIGN KEY (`ID_Status`) REFERENCES `Status` (`ID_Status`) ON DELETE NO ACTION ON UPDATE NO ACTION
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        " );

		DB::statement( "
          CREATE TABLE `BikePart` (
            `ID_BPart` int(32) NOT NULL AUTO_INCREMENT,
            `PartName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
            PRIMARY KEY (`ID_BPart`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        " );

		DB::statement( "
          CREATE TABLE `BikePhoto` (
            `ID_BikePhoto` int(11) NOT NULL AUTO_INCREMENT,
            `ID_Bike` int(11) DEFAULT NULL,
            `ID_Photo` int(11) DEFAULT NULL,
            `CreateDateTime` datetime DEFAULT NULL,
            PRIMARY KEY (`ID_BikePhoto`),
            UNIQUE KEY `uq_bike_photo` (`ID_Bike`,`ID_Photo`),
            KEY `fk_BikePhoto_Bike_idx` (`ID_Bike`),
            KEY `fk_BikePhoto_Photo_idx` (`ID_Photo`),
            CONSTRAINT `fk_BikePhoto_Bike` FOREIGN KEY (`ID_Bike`) REFERENCES `Bike` (`ID_Bike`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `fk_BikePhoto_Photo` FOREIGN KEY (`ID_Photo`) REFERENCES `Photo` (`ID_Photo`) ON DELETE NO ACTION ON UPDATE NO ACTION
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        " );

		DB::statement( "
          CREATE TABLE `BikeRepair` (
            `ID_BRepair` int(32) NOT NULL AUTO_INCREMENT,
            `ID_Bike` int(32) NOT NULL,
            `ID_BPart` int(32) NOT NULL,
            `Note` longtext COLLATE utf8mb4_unicode_ci,
            PRIMARY KEY (`ID_BRepair`),
            KEY `fk_BikeRepair_Bike` (`ID_Bike`),
            KEY `fk_BikeRepair_BikePart` (`ID_BPart`),
            CONSTRAINT `fk_BikeRepair_Bike` FOREIGN KEY (`ID_Bike`) REFERENCES `Bike` (`ID_Bike`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `fk_BikeRepair_BikePart` FOREIGN KEY (`ID_BPart`) REFERENCES `BikePart` (`ID_BPart`) ON DELETE NO ACTION ON UPDATE NO ACTION
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        " );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement( "DROP TABLE IF EXISTS `BikeRepair`;" );
		DB::statement( "DROP TABLE IF EXISTS `BikePhoto`;" );
		DB::statement( "DROP TABLE IF EXISTS `BikePart`;" );

		DB::statement( "DROP TABLE IF EXISTS `AccessoryHistory`;" );
		DB::statement( "DROP TABLE IF EXISTS `Accessory`;" );
		DB::statement( "DROP TABLE IF EXISTS `AccessoryType`;" );

		DB::statement( "DROP TABLE IF EXISTS `BikeHistory`;" );
		DB::statement( "DROP TABLE IF EXISTS `Bike`;" );

		DB::statement( "DROP TABLE IF EXISTS `UserPhoto`;" );
		DB::statement( "DROP TABLE IF EXISTS `User`;" );

		DB::statement( "DROP TABLE IF EXISTS `Photo`;" );
		DB::statement( "DROP TABLE IF EXISTS `Status`;" );
	}
}
