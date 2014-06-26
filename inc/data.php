<?php

$select = 'SELECT e.title, e.content, e.time, u.username
				FROM entries as e, users as u
				WHERE e.author = u.id
				ORDER BY e.time DESC';
$content = mysqli_query($db, $select);


