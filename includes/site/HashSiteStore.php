<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

namespace MediaWiki\Site;

/**
 * In-memory SiteStore implementation, stored in an associative array.
 *
 * @since 1.25
 * @ingroup Site
 * @author Daniel Kinzler
 * @author Katie Filbert < aude.wiki@gmail.com >
 */
class HashSiteStore implements SiteStore {
	/** @var Site[] */
	private $sites = [];

	/**
	 * @param Site[] $sites
	 */
	public function __construct( array $sites = [] ) {
		$this->saveSites( $sites );
	}

	/**
	 * Save the provided site.
	 *
	 * @since 1.25
	 * @param Site $site
	 * @return bool Success indicator
	 */
	public function saveSite( Site $site ) {
		$this->sites[$site->getGlobalId()] = $site;

		return true;
	}

	/**
	 * Save the provided sites.
	 *
	 * @since 1.25
	 * @param Site[] $sites
	 * @return bool Success indicator
	 */
	public function saveSites( array $sites ) {
		foreach ( $sites as $site ) {
			$this->saveSite( $site );
		}

		return true;
	}

	/**
	 * Return the site with provided global ID, or null if there is no such site.
	 *
	 * @since 1.25
	 * @param string $globalId
	 * @param string $source either 'cache' or 'recache'.
	 *  If 'cache', the values can (but not obliged) come from a cache.
	 * @return Site|null
	 */
	public function getSite( $globalId, $source = 'cache' ) {
		return $this->sites[$globalId] ?? null;
	}

	/**
	 * Return a list of all sites.
	 *
	 * By default this list is fetched from the cache, which can be changed to loading
	 * the list from the database using the $useCache parameter.
	 *
	 * @since 1.25
	 * @param string $source either 'cache' or 'recache'.
	 *  If 'cache', the values can (but not obliged) come from a cache.
	 * @return SiteList
	 */
	public function getSites( $source = 'cache' ) {
		return new SiteList( $this->sites );
	}

	/**
	 * Delete all sites from the database.
	 *
	 * After calling clear(), getSites() will return an empty list and getSite() will
	 * return null until saveSite() or saveSites() is called.
	 *
	 * @return bool
	 */
	public function clear() {
		$this->sites = [];
		return true;
	}

}

/** @deprecated class alias since 1.42 */
class_alias( HashSiteStore::class, 'HashSiteStore' );
