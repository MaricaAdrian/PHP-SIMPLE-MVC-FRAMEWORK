<div class="wrapper row2">
    <div id="container" class="clear">
        <!-- content body -->
        <div class="container">

            <form action="<?php echo BASE_URL . "register/user_register" ?>" method="post">

                <h1>Register</h1>

                <fieldset>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name"
                    <?php if (is_array($data)) if(array_key_exists('name_r', $data)) { echo "value=\"" . $data['name_r'] . "\""; }
                    ?> required>

                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" <?php if (is_array($data)) if(array_key_exists('name_r', $data)) { echo "value=\"" . $data['email_r'] . "\""; } ?> required>

                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" <?php if (is_array($data)) if(array_key_exists('name_r', $data)) { echo "value=\"" . $data['username_r'] . "\""; } ?> required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                    <label for="rpassword">Repeat password:</label>
                    <input type="password" id="rpassword" name="rpassword" required>
                </fieldset>
                <input id="remember" type="checkbox" name="remember" value="1" />Accept terms and conditions.
                <?php
                  if (!empty($data)) {
                    foreach ($data as $key => $value) {
                      if(strpos($key, "_r") === FALSE)
                        echo "<h3 style=\"color: red;\" id=\"error\">" . $data[$key] ."</h3>";
                    }
                  } elseif (is_int($data)) {
                    echo "<h3 style=\"color: green;\" id=\"error\"> Cont inregistrat cu succes.</h3>";
                  }
                ?>
                <button id="submit" type="submit">Login</button>
            </form>
        </div><!-- container -->
    </div>
</div>
