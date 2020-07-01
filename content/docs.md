---
views:
    kursrepo:
        region: sidebar-right
        template: anax/v2/block/default
        data:
            meta: 
                type: single
                route: block/om-kursrepo

    redovisa:
        region: sidebar-right
        template: anax/v2/block/default
        data:
            meta: 
                type: single
                route: block/om-redovisa
---
###Docs for location api


<p>API can be found via <a href="api/location">/api/location</a></p>
<p>Example 1: <a href="api/location/?method=get&loc=https://jsonplaceholder.typicode.com/todos/1">/api/location/?method=get&loc=https://jsonplaceholder.typicode.com/todos/1</a></p>
<p>Example 2: <a href="api/location/?method=get&loc=https://jsonplaceholder.typicode.com/todos/1">/api/geo/search?ip=216.58.208.110</a></p>
<p>Example 3: <a href="api/location/?method=get&loc=https://jsonplaceholder.typicode.com/todos/1">/api/geo/search?ip=1.2.3.4.5</a></p>