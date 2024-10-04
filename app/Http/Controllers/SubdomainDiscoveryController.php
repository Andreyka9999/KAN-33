<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//use GuzzleHttp\Client;

class SubdomainDiscoveryController extends Controller
{
    public function showForm() 
    {
        return view('subdomains');
    }
    // Request class provides an object-oriented way to interact with the current HHTP request, as well as retrieving the input.
    public function discover(Request $request) {

        //Validation of input data. The field under validation must have a valid A or AAAA record according to the dns_get_record PHP function.

        $validator = Validator::make($request->all(), [
            // Check if the URL adress fir requirements
            'url' => 'required|url',
        ]);

        $url = $request->input('url');
            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
}

            if ($validator->fails()) 
            {
                
                return back()->withErrors($validator)->withInput();
            }

        // Get domain from  URL`s

        $url = parse_url($request->input('url'), PHP_URL_HOST);

            if (!$url) 
            {
                
                return back()->with('error', 'Incorret URL format');
            }

        //Searching subdomains through DNS records

        $subdomains=$this->findSubdomains($url);

        //Return the view with the results
            return view('subdomains', compact('subdomains', 'url'));

    }

    private function findSubdomains($domain) 
    {
            //Get DNS records
            $records = dns_get_record($domain, DNS_A | DNS_CNAME | DNS_NS);
            $subdomains = [];

            foreach ($records as $record) 
            {
                if (isset($record['target']) && strpos($record['target'], $domain) !== false) 
                {
                    $subdomains[] = $record['target'];
                }
            }
            
            // return array_unique($subdomains); returns an array with unique values, 
            // removing any duplicates in the $subdomains array.
            return array_unique($subdomains); 
    }
}
