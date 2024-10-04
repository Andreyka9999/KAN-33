<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subdomain Discovery</title>
</head>

<body>
    <h1>Subdomain Discovery Tool</h1>

    {{-- Input form for URL --}}
    <form action="{{ route('subdomains.discover') }}" method="POST">
    {{--Tokens for CSRF attack protection --}}
        @csrf
        <label for="url">Enter URL (e.g., example.com):</label>
        <input type="text" name="url" id="url" value="{{ old('url') }}" required>
        <button type="submit">Discover Subdomains</button>
    </form>

    {{-- Output of validation errors --}}
    @if ($errors->any())
        <div>
            <ul>
                {{--Scan each error and display--}}
                @foreach ($errors->all() as $error)
                    <li>{{ $error }} For example (e.g. "example.com")</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- If subdomains were found, display them as a list. --}}
    @if (isset($subdomains) && count($subdomains) > 0)
        <h2>Subdomains for {{ $url }}:</h2>
        <ul>
            @foreach ($subdomains as $subdomain)
                <li><a href="http://{{ $subdomain }}" target="_blank">{{ $subdomain }}</a></li>
            @endforeach
        </ul>
    {{--If subdomains were not founded display error--}}
    @elseif (isset($subdomains))
        <p>No subdomains found for {{ $url }}.</p>
    @endif
</body>

</html>
