import { languageProcessing } from "yoastseo";
const { AbstractResearcher } = languageProcessing;
import { enableFeatures, isFeatureEnabled, enabledFeatures } from "@yoast/feature-flag";

// All config
import functionWords from "./config/functionWords";

// All helpers
import getStemmer from "./helpers/getStemmer";

// // The list of the feature flag names
// const featureNames = [ 'NORWEGIAN_READABILITY' ];

/**
 * The researches contains all the researches
 */
export default class Researcher extends AbstractResearcher {
	/**
	 * Constructor
	 * @param {Paper} paper The Paper object that is needed within the researches.
	 * @constructor
	 */
	constructor( paper ) {
		super( paper );

		// Delete Flesch Reading Ease research since Norwegian doesn't have the support for it
		delete this.defaultResearches.getFleschReadingScore;

		// Enable the other Norwegian readability features
		//enableFeatures( [ 'NORWEGIAN_READABILITY' ] );

		if ( isFeatureEnabled("norwegian-readability" ) ) {
			Object.assign( this.config, {
				passiveConstructionType: "morphologicalAndPeriphrastic",
				transitionWords: ["of"],
				twoPartTransitionWords: [["of", "and"]],
				firstWordExceptions: ["the"],
			} );
		/*	Object.assign( this.helpers, {
				getSentenceParts,
				isPassiveSentencePart,
				isPassiveSentence,
			} );*/
		} else {
			// Delete the researches for other readability assessments when the feature is not enabled.
			delete this.defaultResearches.findTransitionWords;
			delete this.defaultResearches.getPassiveVoice;
			delete this.defaultResearches.getSentenceBeginnings;
		}

		Object.assign( this.config, {
			language: "nb",
			functionWords,
		} );

		Object.assign( this.helpers, {
			getStemmer,
		} );
	}
}
