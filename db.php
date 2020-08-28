<?php
  include_once('db_config.php');
  // Directions: place the lines below in db_config.php and edit to match your server
  // // Configuration.
  // // MaNGOSD IP.
  // $realmip = "127.0.0.1";
  // // MaNGOSD port.
  // $realmport = "8085";
  // // MySQL IP (and port).
  // $ip = "127.0.0.1:3306";
  // // MySQL Username.
  // $user = "root";
  // // MySQL Password.
  // $pass = "root";
  // // Realm database.
  // $r_db = "realmd";
  // // Character database.
  // $c_db = "characters";
  // // Images directory.
  // $img_base = "images/";
  // // End config.

  $maps_a = Array(
    0 => 'Eastern Kingdoms',
    1 => 'Kalimdor',
    2 => 'UnderMine',
    13 => 'Test zone',
    17 => 'Kalidar',
    30 => 'Alterac Valley',
    33 => 'Shadowfang Keep',
    34 => 'The Stockade',
    35 => 'Stormwind Prison',
    36 => 'Deadmines',
    37 => 'Plains of Snow',
    43 => 'Wailing Caverns',
    44 => 'Monastery Interior',
    47 => 'Razorfen Kraul',
    48 => 'Blackfathom Deeps',
    70 => 'Uldaman',
    90 => 'Gnomeregan',
    109 => 'Sunken Temple',
    129 => 'Razorfen Downs',
    169 => 'Emerald Forest',
    189 => 'Scarlet Monastery',
    209 => 'Zul\'Farrak',
    229 => 'Blackrock Spire',
    230 => 'Blackrock Depths',
    249 => 'Onyxias Lair',
    269 => 'Caverns of Time',
    289 => 'Scholomance',
    309 => 'Zul\'Gurub',
    329 => 'Stratholme',
    349 => 'Maraudon',
    369 => 'Deeprun Tram',
    389 => 'Ragefire Chasm',
    409 => 'The Molten Core',
    429 => 'Dire Maul',
    449 => 'Alliance PVP Barracks',
    450 => 'Horde PVP Barracks',
    451 => 'Development Land',
    469 => 'Blackwing Lair',
    489 => 'Warsong Gulch',
    509 => 'Ruins of Ahn\'Qiraj',
    529 => 'Arathi Basin',
    531 => 'Temple of Ahn\'Qiraj',
    533 => 'Naxxramas',
  );

  $def = Array(
    'character_race' => Array(
      1 => 'Human',
      2 => 'Orc',
      3 => 'Dwarf',
      4 => 'Night&nbsp;Elf',
      5 => 'Undead',
      6 => 'Tauren',
      7 => 'Gnome',
      8 => 'Troll',
      9 => 'Goblin',
    ),

    'character_class' => Array(
      1 => 'Warrior',
      2 => 'Paladin',
      3 => 'Hunter',
      4 => 'Rogue',
      5 => 'Priest',
      7 => 'Shaman',
      8 => 'Mage',
      9 => 'Warlock',
      11 => 'Druid',
    ),
  );
?>
