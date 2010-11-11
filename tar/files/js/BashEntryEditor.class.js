/**
 * Bash Editor JavaScript Class
 * @author		Johannes Donath
 * @copyright	2010 Punksoft
 * @licence		Punksoft Commercial Licence
 */

var BashEntryEditor = {
	
		votePositive			:			function(entryID) {
			$j.ajax({url: 'index.php?action=BashEntryVotePositive&ajax=1&entryID='+entryID+SID_ARG_2ND });
			$('vote'+entryID+'Positive').fade();
			$('vote'+entryID+'Negative').fade();
		},
		
		voteNegative			:			function(entryID) {
			$j.ajax({url: 'index.php?action=BashEntryVoteNegative&ajax=1&entryID='+entryID+SID_ARG_2ND });
			$('vote'+entryID+'Positive').fade();
			$('vote'+entryID+'Negative').fade();
		},
		
		remove					:			function(entryID) {
			$j.ajax({url: 'index.php?action=BashEntryDelete&ajax=1&entryID='+entryID+SID_ARG_2ND });
			$('entry' + entryID + 'Container').fade();
		}
};