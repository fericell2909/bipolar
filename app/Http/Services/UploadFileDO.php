<?php
 namespace App\Http\Services;

use Aws\S3\S3Client;
use Aws\Credentials\Credentials;
use PhpParser\Node\Stmt\TryCatch;

class UploadFileDO
{
	protected $s3 = true;

	function __construct() {
		//$credentials = new Credentials(env("DO_KEY"), env("DO_SECRET"));
		$credentials = new Credentials(config('digitalocean.do_key'), config('digitalocean.do_secret'));

		$this->s3 = new S3Client([
			"credentials" => $credentials,
			"version" => 'latest',
			"region"  => "us-east-1",
			"endpoint" => config('digitalocean.do_endpoint'),
		]);
	}
	public function list($value='')
	{
		$results = $this->s3->getPaginator('ListObjects', [
			'Bucket' => config('digitalocean.do_bucket'),
			'Prefix' => config('digitalocean.do_folder')
		]);
		
		/* foreach ($results as $key => $value) {
			var_dump($value['Contents']);
		} */
	}
	public function put($folder, $key,$file_location,$mime)
	{

		$results = $this->s3->putObject([
			'Bucket'		=> config('digitalocean.do_bucket'),
			'Key'			=> $folder .'/'. $key,
			'SourceFile'	=> $file_location,
			'ContentType' 	=> $mime,
			'ACL'			=> 'public-read'
		]);
		return $results;
	}

	public function delete($url_foler_name_imagepath)
	{

		$result = $this->s3->deleteObject([
			'Bucket' => config('digitalocean.do_bucket'),
			'Key'    =>  ''.$url_foler_name_imagepath,
		]);

		return $result;
	}


}
/*
class UploadFileDO
{
	protected $s3 = true;

	function __construct() {
		$credentials = new Credentials('HCJKUTEIJQ72UM2YNFNL', 'odCDEkAY+HLFxsi1Ie1icw9RiZOUKclzPqXEfiezlBk');

		$this->s3 = new S3Client([
			"credentials" => $credentials,
			"version" => 'latest',
			"region"  => "us-east-1",
			"endpoint" => 'https://nyc3.digitaloceanspaces.com',
		]);
	}
	
	public function put($folder, $key,$file_location,$mime)
	{

		$results = $this->s3->putObject([
			'Bucket'		=> "devmarcoestrada",
			'Key'			=> $folder .'/'. $key,
			'SourceFile'	=> $file_location,
			'ContentType' 	=> $mime,
			'ACL'			=> 'public-read'
		]);
		return $results;
	}

	public function delete($url_foler_name_imagepath)
	{

		$result = $this->s3->deleteObject([
			'Bucket' => "devmarcoestrada",
			'Key'    =>  ''.$url_foler_name_imagepath,
		]);

		return $result;
	}

	
}	
*/