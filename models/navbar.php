<?php 
/*
"NoBull"Cake
built using UserCake Version: 2.0.2
*/
$pages = fetchAllPages();
foreach($pages as $page){
	$pageDetails = fetchPageDetails($page['id']); 
	if($pageDetails['nav'] == 1){
		if($pageDetails['private'] == 1){
			if(isUserLoggedIn()){
				// private
				echo "Account";
			}
		}
		else{
			// public link
			echo "Public";
		}
	}
}