<?PHP

    $server = "quipenseuzplop.mysql.db";
    $db = "quipenseuzplop";
    $user = "quipenseuzplop";
    $pass = "Levietnam42";

    echo "Check1";

    try
    {
        echo "Check1.5";
        $pdo = new PDO('mysql:host=' . $server . ';dbname=' . $db, $user, $pass, array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //////////////////////////////////////////////////////////////////////
        //                                                                  //
        //                              TABLE USER                          //
        //                                                                  //
        //////////////////////////////////////////////////////////////////////
        
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            firstname VARCHAR(255),
            img VARCHAR(255) NOT NULL,
            pass VARCHAR(255) NOT NULL,
            salt VARCHAR(255) NOT NULL,
            last_plopinion_id INT(11) NOT NULL,
            creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            modification_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            log_num INT(11) NOT NULL,
            active BOOLEAN DEFAULT TRUE
        )";
        
        $request = $pdo->prepare($sql);
        $request->execute();
        
        //////////////////////////////////////////////////////////////////////
        //                                                                  //
        //                        TABLE USER_PLOPINION                      //
        //                                                                  //
        //////////////////////////////////////////////////////////////////////
        
        $sql = "CREATE TABLE IF NOT EXISTS user_plopinion (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            user_id INT(11) NOT NULL,
            plopinion_id INT(11) NOT NULL,
            creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            modification_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            active BOOLEAN DEFAULT TRUE
        )";

        $request = $pdo->prepare($sql);
        $request->execute();
        
        //////////////////////////////////////////////////////////////////////
        //                                                                  //
        //                      TABLE LIST_INVITATION                       //
        //                                                                  //
        //////////////////////////////////////////////////////////////////////
        
        $sql = "CREATE TABLE IF NOT EXISTS list_invitation (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            plopinion_id INT(11) NOT NULL,
            mail VARCHAR(255) NOT NULL,
            active BOOLEAN DEFAULT TRUE
        )";

        $request = $pdo->prepare($sql);
        $request->execute();
        
        //////////////////////////////////////////////////////////////////////
        //                                                                  //
        //                           TABLE WHITELIST                        //
        //                                                                  //
        //////////////////////////////////////////////////////////////////////
        
        $sql = "CREATE TABLE IF NOT EXISTS whitelist (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            plopinion_id INT(11) NOT NULL,
            mail VARCHAR(255) NOT NULL,
            active BOOLEAN DEFAULT TRUE
        )";

        $request = $pdo->prepare($sql);
        $request->execute();
        
        //////////////////////////////////////////////////////////////////////
        //                                                                  //
        //                             TABLE IMAGE                          //
        //                                                                  //
        //////////////////////////////////////////////////////////////////////
        
        $sql = "CREATE TABLE IF NOT EXISTS image (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            plop_id INT(11) NOT NULL,
            url VARCHAR(255) NOT NULL,
            active BOOLEAN DEFAULT TRUE
        )";

        $request = $pdo->prepare($sql);
        $request->execute();
        
        //////////////////////////////////////////////////////////////////////
        //                                                                  //
        //                             TABLE TABS                           //
        //                                                                  //
        //////////////////////////////////////////////////////////////////////
        
        $sql = "CREATE TABLE IF NOT EXISTS tabs (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            plopinion_id INT(11) NOT NULL,
            title VARCHAR(255) NOT NULL,
            creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            modification_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            group_id INT(11),
            has_budget BOOLEAN DEFAULT FALSE,
            budget_type INT(5) DEFAULT 0,
            active BOOLEAN DEFAULT TRUE
        )";

        $request = $pdo->prepare($sql);
        $request->execute();
        
        //////////////////////////////////////////////////////////////////////
        //                                                                  //
        //                             TABLE LABELS                         //
        //                                                                  //
        //////////////////////////////////////////////////////////////////////
        
        $sql = "CREATE TABLE IF NOT EXISTS labels (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            plopinion_id INT(11) NOT NULL,
            title VARCHAR(255) NOT NULL,
            color VARCHAR(10) NOT NULL,
            creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            modification_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            active BOOLEAN DEFAULT TRUE
        )";

        $request = $pdo->prepare($sql);
        $request->execute();
        
        
        //////////////////////////////////////////////////////////////////////
        //                                                                  //
        //                      INSERT TABLE LABELS                         //
        //                                                                  //
        //////////////////////////////////////////////////////////////////////
        
        $sql = "SELECT * FROM labels WHERE plopinion_id=0";
        
        $request = $pdo->prepare($sql);
        $request->execute();
        
        $row = $request->fetchAll();
        
        if (!$row)
        {
            $sql = "INSERT INTO labels VALUES (
                '0',
                '0',
                'Tous',
                '#ff00ff',
                CURRENT_TIMESTAMP,
                CURRENT_TIMESTAMP,
                TRUE
            )";
        
            $request = $pdo->prepare($sql);
            $request->execute();
        }
        
        //////////////////////////////////////////////////////////////////////
        //                                                                  //
        //                             TABLE GROUPS                         //
        //                                                                  //
        //////////////////////////////////////////////////////////////////////
        
        $sql = "CREATE TABLE IF NOT EXISTS groups (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            plopinion_id INT(11) NOT NULL,
            name VARCHAR(255) NOT NULL,
            creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            modification_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            active BOOLEAN DEFAULT TRUE
        )";
        
        $request = $pdo->prepare($sql);
        $request->execute();
        
        
        //////////////////////////////////////////////////////////////////////
        //                                                                  //
        //                         TABLE GROUP_USER                         //
        //                                                                  //
        //////////////////////////////////////////////////////////////////////
        
        $sql = "CREATE TABLE IF NOT EXISTS group_user (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            user_id INT(11) NOT NULL,
            group_id INT(11) NOT NULL,
            active BOOLEAN DEFAULT TRUE
        )";
        
        $request = $pdo->prepare($sql);
        $request->execute();
        
        //////////////////////////////////////////////////////////////////////
        //                                                                  //
        //                             TABLE VOTES                          //
        //                                                                  //
        //////////////////////////////////////////////////////////////////////
        
        $sql = "CREATE TABLE IF NOT EXISTS votes (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            user_id INT(11) NOT NULL,
            plop_id INT(11) NOT NULL,
            vote INT(11) NOT NULL,
            veto BOOLEAN,
            heart BOOLEAN,
            creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            modification_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            active BOOLEAN DEFAULT TRUE
        )";
        
        $request = $pdo->prepare($sql);
        $request->execute();
        
        //////////////////////////////////////////////////////////////////////
        //                                                                  //
        //                           TABLE MESSAGES                         //
        //                                                                  //
        //////////////////////////////////////////////////////////////////////
        
        $sql = "CREATE TABLE IF NOT EXISTS messages (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            user_id INT(11) NOT NULL,
            plop_id INT(11) NOT NULL,
            comment TEXT NOT NULL,
            creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            modification_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            active BOOLEAN DEFAULT TRUE
        )";
        
        $request = $pdo->prepare($sql);
        $request->execute();
        
        //////////////////////////////////////////////////////////////////////
        //                                                                  //
        //                           TABLE PLOPS                            //
        //                                                                  //
        //////////////////////////////////////////////////////////////////////
        
        $sql = "CREATE TABLE IF NOT EXISTS plops (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            user_id INT(11) NOT NULL,
            plopinion_id INT(11) NOT NULL,
            tabs_id INT(11) NOT NULL,
            anonymous BOOLEAN,
            label_id INT(11) DEFAULT 0,
            score INT(11) DEFAULT 0,
            nbvote INT(11) DEFAULT 0,
            admin_answer VARCHAR(255) DEFAULT NULL,
            user_answer VARCHAR(255) DEFAULT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT DEFAULT NULL,
            creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            modification_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            active BOOLEAN DEFAULT TRUE
        )";
        
        $request = $pdo->prepare($sql);
        $request->execute();
        
        //////////////////////////////////////////////////////////////////////
        //                                                                  //
        //                         TABLE PLOPINIONS                         //
        //                                                                  //
        //////////////////////////////////////////////////////////////////////
        
        $sql = "CREATE TABLE IF NOT EXISTS plopinions (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            user_id INT(11) NOT NULL,
            code VARCHAR(255) NOT NULL,
            status INT(5) NOT NULL,
            name VARCHAR(255) NOT NULL,
            admins_id TEXT NOT NULL,
            max_heart INT(5) DEFAULT 3,
            max_veto INT(5) DEFAULT 3,
            can_anonymous_plop INT(5) DEFAULT 2,
            can_score_before_vote BOOLEAN DEFAULT FALSE,
            can_modify_vote BOOLEAN DEFAULT FALSE,
            is_public BOOLEAN DEFAULT TRUE,
            has_whitelist BOOLEAN DEFAULT FALSE,
            nbveto INT(11) DEFAULT 0,
            nbheart INT(11) DEFAULT 0,
            nbvote INT(11) DEFAULT 0,
            nbplop INT(11) DEFAULT 0,
            nbuser INT(11) DEFAULT 1,
            nbtab INT(11) DEFAULT 0,
            nbadmin INT(11) DEFAULT 1,
            nbmaxplop INT(11) DEFAULT 125,
            nbmaxfield INT(11) DEFAULT 3,
            nbmaxtab INT(11) DEFAULT 4,
            nbmaxadmin INT(11) DEFAULT 1,
            ads BOOLEAN DEFAULT TRUE,
            url_logo VARCHAR(255) NOT NULL,
            usage_type VARCHAR(255) NOT NULL,
            usage_target VARCHAR(255) NOT NULL,
            creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            modification_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            active BOOLEAN DEFAULT TRUE
        )";
        
        $request = $pdo->prepare($sql);
        $request->execute();
        
        //////////////////////////////////////////////////////////////////////
        //                                                                  //
        //                         TABLE SMARTFIELDS                        //
        //                                                                  //
        //////////////////////////////////////////////////////////////////////
        
        $sql = "CREATE TABLE IF NOT EXISTS smartfields (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            plop_id INT(11) NOT NULL,
            type INT(5) NOT NULL,
            info VARCHAR(255) NOT NULL,
            text VARCHAR(255) NOT NULL,
            active BOOLEAN DEFAULT TRUE
        )";
        
        $request = $pdo->prepare($sql);
        $request->execute();
        
    }
    catch (PDOException $e)
    {
        echo "ERROR: " . $e->getMessage();
        die();
    }

    