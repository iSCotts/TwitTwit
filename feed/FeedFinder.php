<?php
/*
 * FeedFinder
 * Author: Manel Zaera (manelzaera@gmail.com)
 * Description: Singleton class to find syndication feeds in
 * a website.
 * Creation date: 2007-11-06
 *
 * Modified by:
 * 2007-11-16 - Manel Zaera (manelzaera@gmail.com) - Reduce number of URL fetches
 * 2007-11-21 - Manel Zaera (manelzaera@gmail.com) - Return array of feeds indicating the type of each feed
 * 2007-11-24 - Manel Zaera (manelzaera@gmail.com) - Add feed title to returned array
 * 2007-12-03 - Manel Zaera (manelzaera@gmail.com) - Solve parse errors, avoid warning messages on HTML loading
 * 2007-12-28 - Manel Zaera (manelzaera@gmail.com) - Recognize partial feed URLs from HTML document header and get feeds from OPML file
 * 2008-01-17 - Manel Zaera (manelzaera@gmail.com) - Fix wrong absolute URL construction in getAbsoluteUrl
 *
 * This work is published under the GPL license (http://www.gnu.org/copyleft/gpl.html)
 *
 */
class FeedFinder {
	private static $sInstance = null;
	const MIME_RSS = 'application/rss+xml';
	const MIME_ATOM = 'application/atom+xml';
	const XMLNS_RSS1 = 'http://purl.org/rss/1.0/';
	const XMLNS_ATOM1 = 'http://www.w3.org/2005/Atom';
	const XMLNS_ATOM2 = 'http://purl.org/atom/ns#';

	// Feed array element constants
	const FEED_FIELD_TYPE = 'type';
	const FEED_FIELD_URL = 'url';
	const FEED_FIELD_TITLE = 'title';

	// Feed type constants
	const FEED_TYPE_NONE = 0;
	const FEED_TYPE_RSS1 = 1;
	const FEED_TYPE_RSS2 = 2;
	const FEED_TYPE_ATOM = 3;
	const FEED_TYPE_OPML = 4;

	private function __construct() {

	}

	/**
	 * Gets the unique class instance
	 */
	public static function getInstance() {
		if (self::$sInstance == null) {
			self::$sInstance = new FeedFinder();
		}
		return self::$sInstance;
	}

	/**
	 * Get the feeds discovered from a URL
	 * @param $aUrl URL that can be a feed
	 * or that contains one or more
	 * feed references
	 *
	 * @return Array of found feed URLs, null otherwise. The array elements are 'url', 'type' and 'title' data.
	 */
	public function getFeeds($aUrl) {
		$aaFeeds = array();
		try {
			$aDoc = $this->prepareXmlReader($aUrl);
			$aType = $this->typeOfDoc($aDoc);
			$aTitle = ($aType!=self::FEED_TYPE_NONE || $aType!=self::FEED_TYPE_OPML)?$this->getFeedTitle($aDoc):null;
			if ($aType!=self::FEED_TYPE_NONE && $aType!=self::FEED_TYPE_OPML) {
				$aFeed = array(self::FEED_FIELD_TYPE=>$aType, self::FEED_FIELD_URL=>$aUrl, self::FEED_FIELD_TITLE=>$aTitle);
				$aaFeeds[] = $aFeed;
			} elseif ($aType==self::FEED_TYPE_OPML) {
				$aaFeeds = $this->getFeedsFromOpml($aDoc);
			} else {
				// Not a feed URL -> find feeds in document
				$aaFeeds = $this->discoverFeeds($aUrl);
			}
			$aDoc->close();
		} catch (Exception $aEx) {
			// Do nothing
		}
		return $aaFeeds;
	}

    /**
     * Check if a URL is a feed URL
     * @param $aUrl URL to analyze
     */
	public function isFeed($aUrl) {
		try {
			$aDoc = $this->prepareXmlReader($aUrl);
			$zIsFeed = ($this->isRssDoc($aDoc) || $this->isAtomDoc($aDoc));
			$aDoc->close();
		} catch (Exception $aEx) {
			$zIsFeed = false;
		}
		return $zIsFeed;
	}

	/**
	 * Check if a URL is RSS 1.0 or RSS 2.0 feed
	 * @param $aUrl URL to analyze
	 */
	public function isRss($aUrl) {
		try {
			$aDoc = $this->prepareXmlReader($aUrl);
			$zIsRss = $this->isRssDoc($aDoc);
			$aDoc->close();
		} catch (Exception $aEx) {
			$zIsRss = false;
		}
		return $zIsRss;
	}

	/**
	 * Check if a URL is a RSS 1.0 feed
	 * @param $aUrl URL to analyze
	 */
	public function isRss1($aUrl) {
		try {
			$aDoc = $this->prepareXmlReader($aUrl);
			$zIsRss1 = $this->isRss1Doc($aDoc);
			$aDoc->close();
		} catch (Exception $aEx) {
			$zIsRss1 = false;
		}
		return $zIsRss1;
	}

	/**
	 * Check if a URL is a RSS 2.0 feed
	 * @param $aUrl URL to analyze
	 */
	public function isRss2($aUrl) {
		try {
			$aDoc = $this->prepareXmlReader($aUrl);
			$zIsRss2 = $this->isRss2Doc($aDoc);
			$aDoc->close();
		} catch (Exception $aEx) {
			$zIsRss2 = false;
		}
		return $zIsRss2;
	}

	/**
	 * Check if a URL is an Atom feed
	 * @param $aUrl URL to analyze
	 */
	public function isAtom($aUrl) {
		try {
			$aDoc = $this->prepareXmlReader($aUrl);
			$zIsAtom = $this->isAtomDoc($aDoc);
			$aDoc->close();
		} catch (Exception $aEx) {
			$zIsAtom = false;
		}
		return $zIsAtom;
	}

	/**
	 * Check if a URL is an OPML feed list
	 * @param $aUrl URL to analyze
	 */
	public function isOpml($aUrl) {
		try {
			$aDoc = $this->prepareXmlReader($aUrl);
			$zIsOpml = $this->isOpmlDoc($aDoc);
			$aDoc->close();
		} catch (Exception $aEx) {
			$zIsOpml = false;
		}
		return $zIsOpml;
	}

	/*
	 * Look for feeds within a document
	 * @param $aUrl URL of document
	 *
	 * @return Array of feed URLs
	 */
	private function discoverFeeds($aUrl) {
		$aFeeds = array();
		try {
			$aDocument = new DOMDocument();
			// Avoid HTML load warnings
			@$aDocument->loadHTMLFile($aUrl);
			$aDocument->normalize();
			$aElements = $aDocument->getElementsByTagName('link');
			foreach ($aElements as $aElement) {
				$aRel = $aElement->getAttribute('rel');
				$aAttrType = $aElement->getAttribute('type');
				if ($aRel == 'alternate' && ($aAttrType == self::MIME_RSS || $aAttrType == self::MIME_ATOM)) {
					try {
						$aHref = $this->getAbsoluteUrl($aElement->getAttribute('href'),$aUrl);
						$aDoc = $this->prepareXmlReader($aHref);
						$aType = $this->typeOfDoc($aDoc);
						$aTitle = $this->getFeedTitle($aDoc);
						if ($aType != self::FEED_TYPE_NONE) {
							$aFeed = array(self::FEED_FIELD_TYPE=>$aType, self::FEED_FIELD_URL=>$aHref,self::FEED_FIELD_TITLE=>$aTitle);
							$aFeeds[] = $aFeed;
						}
						$aDoc->close();
					} catch (Exception $aEx) {
						// Do nothing
					}
				}
			}
		} catch (Exception $aEx) {
			// None
		}
		return $aFeeds;
	}

	/**
	 * Get the type of feed for a Url
	 * @param $aUrl URL to check
	 *
	 * @return Number One of the constant values in this class related to feed types
	 */
	public function typeOf($aUrl) {
		try {
			$aDoc = $this->prepareXmlReader($aUrl);
			$aType = $this->typeOfDoc($aDoc);
			$aDoc->close();
		} catch (Exception $aEx) {
			$aType = self::FEED_TYPE_NONE;
		}
		return $aType;
	}

	/*
	 * Get the type of a loaded document
	 * @param $aDoc Loaded XML document, positioned at first element
	 */
	private function typeOfDoc($aDoc) {
		$aType = self::FEED_TYPE_NONE;
		if ($this->isRss1Doc($aDoc)) {
			$aType = self::FEED_TYPE_RSS1;
		} elseif ($this->isRss2Doc($aDoc)) {
			$aType = self::FEED_TYPE_RSS2;
		} elseif ($this->isAtomDoc($aDoc)) {
			$aType = self::FEED_TYPE_ATOM;
		} elseif ($this->isOpmlDoc($aDoc)) {
			$aType = self::FEED_TYPE_OPML;
		}
		return $aType;
	}

	/*
	 * Check if a loaded document is RSS 1.0 or RSS 2.0 feed
	 * @param $aDoc Loaded XML document, positioned at first element
	 */
	private function isRssDoc($aDoc) {
		$zIsRss = $this->isRss2Doc($aDoc);
		if (!$zIsRss) {
			$zIsRss = $this->isRss1Doc($aDoc);
		}
		return $zIsRss;
	}

	/*
	 * Check if a loaded document is a RSS 2.0 feed
	 * @param $aDoc Loaded XML document, positioned at first element
	 */
	private function isRss2Doc($aDoc) {
		return ($aDoc->name == 'rss');
	}

	/*
	 * Check if a loaded documentL is a RSS 1.0 feed
	 * @param $aDoc Loaded XML document, positioned at first element
	 */
	private function isRss1Doc($aDoc) {
		$zIsRss1 = false;
		try {
			$zIsRss1 = ($aDoc->name == 'rdf:RDF') && ($aDoc->getAttribute('xmlns') == self::XMLNS_RSS1);
		} catch (Exception $aEx) {
			//
		}
		return $zIsRss1;
	}

	/*
	 * Check if a loaded document is an Atom feed
	 * @param $aDoc Loaded XML document, positioned at first element
	 */
	private function isAtomDoc($aDoc) {
		return ($aDoc->name == 'feed' && ($aDoc->namespaceURI == self::XMLNS_ATOM1 || $aDoc->namespaceURI == self::XMLNS_ATOM2));
	}

	/*
	 * Check if a loaded document is an OPML feed list
	 * @param $aDoc Loaded XML document, positioned at first element
	 */
	private function isOpmlDoc($aDoc) {
		return ($aDoc->name == 'opml');
	}

	/*
	 * Get an XMLReader object from a URL and positions it at the first element
	 * of the document
	 * @param $aUrl URL to get the XMLReader object from
	 */
	private function prepareXmlReader($aUrl) {
		$aDoc = new XMLReader();
		$aDoc->open($aUrl);
		$this->readNextXmlElement($aDoc);
		return $aDoc;
	}

	/*
	 * Get the feed title from a loaded XML document
	 * @param $aDoc XML document
	 */
	private function getFeedTitle($aDoc) {
		$zFound = false;
		$zEnd = false;
		try {
			do {
				$zFound = ($aDoc->name == self::FEED_FIELD_TITLE);
				if (!$zFound) {
					$zEnd = !$this->readNextXmlElement($aDoc,XMLReader::ELEMENT);
				}
			} while (!$zFound && !$zEnd);
			// Read inner text from title element
			if ($zFound) {
				$this->readNextXmlElement($aDoc,XMLReader::TEXT);
			}
		} catch (Exception $aEx) {
			//
		}
		return ($zFound?$aDoc->value:'');
	}

	/*
	 * Read next element in XML document if this
	 * is a valid one
	 */
	private function readNextXmlElement($aDoc,$aNodeType=XMLReader::ELEMENT) {
		// Avoid reading nodes like XML Stylesheet, etc.
		$zReadOk = true;
		do {
			$zReadOk = @$aDoc->read();
		} while ($aDoc->nodeType!=$aNodeType && $zReadOk);
		return $zReadOk;
	}

	/*
	 * Get the absolute URL for a feed
	 * @param $aHref Feed URL (partial or absolute)
	 * @param $aUrl Url to use as base URL if $aHref is not an absolute one
	 */
	private function getAbsoluteUrl($aHref,$aUrl) {
		$aAbsUrl = $aHref;
		$aHrefParts = parse_url($aHref);
		$aScheme = $aHrefParts['scheme'];
		$aPath = $aHrefParts['path'];
		$aQuery = $aHrefParts['query'];
		// An absolute URL has some value in 'scheme' part
		if ($aScheme == '') {
			$aUrlParts = parse_url($aUrl);
			$aScheme = $aUrlParts['scheme'];
			$aHost = $aUrlParts['host'];
			$aUrlPath = $aUrlParts['path'];
			$aAbsUrl = $aScheme.'://'.$aHost.$aUrlPath;
			if ($aAbsUrl[strlen($aAbsUrl)-1] != '/') {
				$aAbsUrl .= '/';
			}
			$aAbsUrl .= $aPath;
			if ($aQuery != '') {
				$aAbsUrl .= '?'.$aQuery;
			}
		}
		return $aAbsUrl;
	}

	/*
	 * Get feeds from a OPML feed list
	 */
	private function getFeedsFromOpml($aDoc) {
		$aaFeeds = array();
		if ($this->goToOpmlBody($aDoc)) {
			$aaFeeds = $this->getOpmlBodyFeeds($aDoc);
		}
		return $aaFeeds;
	}

	/*
	 * Seek the XML document to OPML body element
	 */
	private function goToOpmlBody($aDoc) {
		$zFound = false;
		$zEnd = false;
		try {
			do {
				$zFound = ($aDoc->name == 'body');
				if (!$zFound) {
					$zEnd = !$this->readNextXmlElement($aDoc,XMLReader::ELEMENT);
				}
			} while (!$zFound && !$zEnd);
		} catch (Exception $aEx) {
			//
		}
		return ($zFound);
	}

	/*
	 * Get the feeds in OPML document body
	 */
	private function getOpmlBodyFeeds($aDoc) {
		$zEnd = false;
		$aaFeeds = array();
		try {
			do {
				$zEnd = !$this->readNextXmlElement($aDoc,XMLReader::ELEMENT);
				if ($aDoc->name == 'outline') {
					$aXmlUrl = $aDoc->getAttribute('xmlUrl');
					if ($aXmlUrl != '') {
						try {
							$aFeedType = @$this->typeOf($aXmlUrl);
						} catch (Exception $aInEx) {
							$aFeddType = self::FEED_TYPE_NONE;
						}
						$aFeed = array(self::FEED_FIELD_TYPE=>$aFeedType, self::FEED_FIELD_URL=>$aXmlUrl, self::FEED_FIELD_TITLE=>$aDoc->getAttribute('title'));
						$aaFeeds[] = $aFeed;
					}
				}

			} while (!$zEnd);
		} catch (Exception $aEx) {
			//
		}
		return $aaFeeds;
	}
}
?>
