<?php


use app\core\Migration;

class m0005_create_pastes_table extends Migration
{
    public function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS pastes(
              id INT AUTO_INCREMENT PRIMARY KEY,
              code TEXT NOT NULL,
              burn_after_read BIT,
              password VARCHAR(30),
              expiration_date TIMESTAMP,
              slug VARCHAR(255) NOT NULL,
              title VARCHAR(255) NOT NULL,
              nr_of_views INT,
              id_user INT,
              id_syntax INT,
              exposure BIT,
              FOREIGN KEY (id_user) REFERENCES users(id),
              FOREIGN KEY (id_syntax) REFERENCES highlights(id)
            ) ENGINE=INNODB;
        ";

        app('db')->getPdo()->exec($sql);
    }

    public function down()
    {
        $sql = "DROP TABLE pastes";

        app('db')->getPdo()->exec($sql);
    }
}