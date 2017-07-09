<div class="wrapper row2">
    <div id="container" class="clear">
        <!-- content body -->
        <div class="container">

            <form action="<?php echo BASE_URL . "login/check" ?>" method="post">

                <h1>Login</h1>

                <fieldset>
                    <label for="username">Name:</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                </fieldset>
                <?php
                    if (!empty($data)) {
                      foreach ($data as $key => $value)
                        echo "<h3 style=\"color: red;\" id=\"error\">" . $data[$key] ."</h3>";
                   }
                ?>
                <button id="submit" type="submit">Login</button>
            </form>
        </div><!-- container -->
    </div>
</div>
