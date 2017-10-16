<table border="1" cellpadding="5" cellspacing="2">
    <thead>
        <tr>
            <th>ACTION</th>
            <th>URL</th>
            <th>METHOD</th>
        </tr>
    </thead>
    <tbody>
        @foreach($myApiRoute as $a => $r)
            @php
                //$r = (array) $r;
            @endphp
        <tr>
            <td>{{$a}}</td>
            <td>{{$r->uri}}</td>
            <td>{{implode(' | ', $r->methods) }}</td>
        </tr>
        @endforeach
    </tbody>

</table>