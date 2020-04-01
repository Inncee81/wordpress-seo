<?php
/**
 * Yoast extension of the Model class.
 *
 * @package Yoast\YoastSEO\ORM\Repositories
 */

namespace Yoast\WP\SEO\Repositories;

use Yoast\WP\SEO\Builders\Indexable_Hierarchy_Builder;
use Yoast\WP\SEO\Models\Indexable;
use Yoast\WP\SEO\Models\Indexable_Hierarchy;
use Yoast\WP\SEO\ORM\Yoast_Model;

/**
 * Class Indexable_Hierarchy_Repository
 *
 * @package Yoast\WP\SEO\ORM\Repositories
 */
class Indexable_Hierarchy_Repository {

	/**
	 * Represents the indexable hierarchy builder.
	 *
	 * @var Indexable_Hierarchy_Builder
	 */
	protected $builder;

	/**
	 * Sets the hierarchy builder.
	 *
	 * @required
	 *
	 * @param Indexable_Hierarchy_Builder $builder The indexable hierarchy builder.
	 */
	public function set_builder( Indexable_Hierarchy_Builder $builder ) {
		$this->builder = $builder;
	}

	/**
	 * Removes all ancestors for an indexable.
	 *
	 * @param int $indexable_id The indexable id.
	 *
	 * @return bool Whether or not the indexables were successfully deleted
	 */
	public function clear_ancestors( $indexable_id ) {
		return $this->query()->where( 'indexable_id', $indexable_id )->delete_many();
	}

	/**
	 * Adds an ancestor to an indexable.
	 *
	 * @param int $indexable_id The indexable id.
	 * @param int $ancestor_id  The ancestor id.
	 * @param int $depth        The depth.
	 *
	 * @return bool|Yoast_Model
	 */
	public function add_ancestor( $indexable_id, $ancestor_id, $depth ) {
		$hierarchy = $this->query()->create( [
			'indexable_id' => $indexable_id,
			'ancestor_id'  => $ancestor_id,
			'depth'        => $depth,
		] );
		$hierarchy->save();
		return $hierarchy;
	}

	/**
	 * Retrieves the ancestors. Create them when empty.
	 *
	 * @param Indexable $indexable The indexable to get the ancestors for.
	 *
	 * @return Indexable_Hierarchy[] The ancestors.
	 */
	public function find_ancestors( Indexable $indexable ) {
		$ancestors = $this->query()
			->where( 'indexable_id', $indexable->id )
			->order_by_desc( 'depth' )
			->find_many();

		if ( ! empty( $ancestors ) ) {
			return $ancestors;
		}

		$indexable = $this->builder->build( $indexable );
		$ancestors = $this->query()
			->where( 'indexable_id', $indexable->id )
			->order_by_desc( 'depth' )
			->find_many();

		return $ancestors;
	}

	/**
	 * Starts a query for this repository.
	 *
	 * @return \Yoast\WP\SEO\ORM\ORMWrapper
	 */
	public function query() {
		return Yoast_Model::of_type( 'Indexable_Hierarchy' );
	}
}
