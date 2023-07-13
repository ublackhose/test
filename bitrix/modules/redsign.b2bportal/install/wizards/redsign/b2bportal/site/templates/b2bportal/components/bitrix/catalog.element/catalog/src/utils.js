export function parseHashVars()
{
	const hash = window.location.hash.substring(1);
	const vars = hash.split('&');

	return vars
		.reduce((params, s) => {
			const pair = s.split('=');
			if (pair.length >= 2)
				params[pair[0]] = pair[1];

			return params;
		}, {})
}