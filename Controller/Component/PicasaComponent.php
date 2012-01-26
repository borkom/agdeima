<?php
//component for upload of images to Picasa album, it returns image urls for normal and thumbnail view
class PicasaComponent extends Component {
		
	function getImageUrl($name, $tmpname, $type) {
		set_include_path(get_include_path() . ':/var/www/agdeima/Vendor/');
		require_once 'Zend/Loader.php';
		require_once 'credentials.php';		
		Zend_Loader::loadClass('Zend_Gdata_Photos');
		Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
		Zend_Loader::loadClass('Zend_Gdata_AuthSub');

		$serviceName = Zend_Gdata_Photos::AUTH_SERVICE_NAME;

		$client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $serviceName);

		// update the second argument to be CompanyName-ProductName-Version
		$gp = new Zend_Gdata_Photos($client, "Google-DevelopersGuide-1.0");

		// In version 1.5+, you can enable a debug logging mode to see the
		// underlying HTTP requests being made, as long as you're not using
		// a proxy server
		// $gp->enableRequestDebugLogging('/tmp/gp_requests.log');

		$username = "default";
		$filename = "/tmp/photo.jpg";
		$photoName = "My Test Photo";
		$photoCaption = "The first photo I uploaded to Picasa Web Albums via PHP.";
		$photoTags = "beach, sunshine";

		// We use the albumId of 'default' to indicate that we'd like to upload
		// this photo into the 'drop box'.  This drop box album is automatically
		// created if it does not already exist.
		$albumId = "5690536856110408705";

		$fd = $gp -> newMediaFileSource($tmpname);
		$fd -> setContentType($type);

		// Create a PhotoEntry
		$photoEntry = $gp -> newPhotoEntry();

		$photoEntry -> setMediaSource($fd);
		$photoEntry -> setTitle($gp -> newTitle($name));
		$photoEntry -> setSummary($gp -> newSummary($photoCaption));

		// add some tags
		$keywords = new Zend_Gdata_Media_Extension_MediaKeywords();
		$keywords -> setText($photoTags);
		$photoEntry -> mediaGroup = new Zend_Gdata_Media_Extension_MediaGroup();
		$photoEntry -> mediaGroup -> keywords = $keywords;

		// We use the AlbumQuery class to generate the URL for the album
		$albumQuery = $gp -> newAlbumQuery();

		$albumQuery -> setUser($username);
		$albumQuery -> setAlbumId($albumId);

		// We insert the photo, and the server returns the entry representing
		// that photo after it is uploaded
		$insertedEntry = $gp -> insertPhotoEntry($photoEntry, $albumQuery -> getQueryUrl());
		$mediaGroup = $insertedEntry -> getMediaGroup();
		$content = $mediaGroup -> getContent();
		$thumbnail = $mediaGroup -> getThumbnail();
		$width = $insertedEntry->getGphotoWidth();
		$height = $insertedEntry->getGphotoHeight();
		$url = array('location' => $content[0]->getUrl(), 'thumbnail' => $thumbnail[1]->getUrl(), 'width' => $width->getText(), 'height' => $height->getText());

		return $url;
	}

}
?>