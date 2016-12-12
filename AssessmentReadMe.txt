Assumptions Made:

- “(higher scores are better, and ranks should start at 1)”
	- Means higher scores have lower ranks and lower 
	  scores have higher ranks.
	- i.e Highest score has rank 1, next highest has rank 2 etc...

- LeaderboardGet
	- If there are no records for the specified user in the request
	  then an error response provided

- If an attempt is made to access non-existant endpoint, an error response if provided.

Is there anything you would have done differently, given more time?
	- Add proper documentation to code
	- Thoroughly test endpoints
	- Ensured server was secure
	- Setup unit tests
	- Put more thought of where to place database & transaction key configuration data (in .ini file, or php)
	- Use type declarations