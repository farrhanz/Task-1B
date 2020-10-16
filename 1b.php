<?php 
//require (__DIR__ . './SimpleXLS.php');
include('SimpleXLS.php');

class ListAllCompanies {

	public function getCompanies($id){
		$companies = $this->readFile();
		unset($companies[0]);
		foreach($companies as $company){
			if($company[2]==$id){
				echo "parent company :". $company[1] . $company[0] ."\n";
				foreach ($companies as $childcompany) {
					if($childcompany[2]==$company[0]){
						echo "    child company :". $childcompany[1]."\n";
					}
							
				}
				echo "\n";
			}

		}
	}
	
	//reading file 
	public function readFile(){
		$data = [];
		if ( $xlsx = SimpleXLSX::parse('data.xlsx') ) {
			$data=$xlsx->rows(1);
		} else {
			echo SimpleXLSX::parseError();
		}
    	return $data;
    }
}

$objec = new ListAllCompanies();
$objec->getCompanies($argv[1]);
// command : php 1a.php 1207

?>