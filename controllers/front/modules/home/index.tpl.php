<h1>
    Jobs
</h1>
<html>
<head>
<title>registretion form</title>
</head>
<body>
<form method="post" action="<?php echo getConfig('siteUrl').'/home/index'; ?>">
First Name:<input type="text" size="12" maxlength="12" name="Fname">:<br />
Last Name:<input type="text" size="12" maxlength="36" name="Lname">:<br />
gender::
male:<input type="radio" value="male">:<br />
female:<input type="radio" value="female">:<br />
hobby::
cricket:<input type="checkbox" value="cricket">:<br />
reading:<input type="checkbox" value="reading">:<br />
        <input type="submit" />
</form>
</body>
</head>
</html>
