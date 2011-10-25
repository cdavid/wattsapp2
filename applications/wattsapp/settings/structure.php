<?php if (!defined('APPLICATION')) exit(); // Make sure this file can't get accessed directly
// Use this file to do any database changes for your application.

if (!isset($Drop))
   $Drop = TRUE; // Safe default - Set to TRUE to drop the table if it already exists.
   
if (!isset($Explicit))
   $Explicit = TRUE; // Safe default - Set to TRUE to remove all other columns from table.

$Database = Gdn::Database();
$SQL = $Database->SQL(); // To run queries.
$Construct = $Database->Structure(); // To modify and add database tables.
$Validation = new Gdn_Validation(); // To validate permissions (if necessary).

// Add your tables or new columns under here (see example below).



// Example: New table construction.
/* 
$Construct->Table('ExampleTable')
	->PrimaryKey('ExampleTableID')
   ->Column('ExampleUserID', 'int', TRUE)
   ->Column('Field1', 'varchar(50)')
   ->Set($Explicit, $Drop); // If you omit $Explicit and $Drop they default to false.
*/ 

$Construct->Table('Collector')
   ->PrimaryKey('CollectorID')
   ->Column("Name", 'varchar(50)')
   ->Column("Address", 'varchar(50)')
   ->Column('Visible', 'tinyint(1)', '1') 
   ->Column('Port', 'int')  
   ->Set($Explicit,$Drop);
   
//$Construct->Table('Mote')
//   ->PrimaryKey('MoteID')
//   ->Column('CollectorID', 'int')
//   ->Column('Name', 'varchar(50)')
//   ->Column('Status', 'varchar(50)')
//   ->Column('Type', 'varchar(50)')
//   ->Column('Location', 'varchar(255)')
//   ->Set($Explicit,$Drop);
//   
//$Construct->Table('eLog')
//   ->PrimaryKey('eLogID')
//   ->Column('MoteID', 'int')
//   ->Column('BeginT', 'varchar(50)')
//   ->Column('EndT', 'varchar(50)')
//   ->Column('Value', 'varchar(50)')
//   ->Set($Explicit,$Drop);
   
$Construct->Table('UserCollector')
   ->PrimaryKey('UserCollectorID')
   ->Column('UserID', 'int')
   ->Column('CollectorID', 'int')
   ->Column('PermissionType', 'varchar(50)') //should be view / admin
   ->Set($Explicit,$Drop);
   
$Construct->Table('CollectorRequest')
    ->PrimaryKey('CollectorRequest')
    ->Column('UserID', 'int')
    ->Column('CollectorID', 'int')
    ->Column('Date', 'datetime', TRUE)
    ->Column('Justification', 'text')
    ->Column('Status', 'text')
    ->Set($Explicit, $Drop);
    
//$Construct->Table('UserMote')
//   ->PrimaryKey('UserMoteID')
//   ->Column('UserID')
//   ->Column('MoteID')
//   ->Column('PermissionType') //should be view / admin
//   ->Set($Explicit,$Drop);

// Example: Add column to existing table.
/* 
$Construct->Table('User')
   ->Column('NewColumnNeeded', 'varchar(255)', TRUE) // Always allow for NULLs unless it's truly required.
   ->Set(); 
*/  
   
/**
 * Column() has the following arguments:
 *
 * @param string $Name Name of the column to create.
 * @param string $Type Data type of the column. Length may be specified in parenthesis.
 *    If an array is provided, the type will be set as "enum" and the array's values will be assigned as the column's enum values.
 * @param string $NullOrDefault Default is FALSE. Whether or not nulls are allowed, if not a default can be specified.
 *    TRUE: Nulls allowed. FALSE: Nulls not allowed. Any other value will be used as the default (with nulls disallowed).
 * @param string $KeyType Default is FALSE. Type of key to make this column. Options are: primary, key, or FALSE (not a key).
 *
 * @see /library/database/class.generic.structure.php
 */
