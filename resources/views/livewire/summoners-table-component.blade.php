<div>
    <table class="table-auto">
        <thead>
            <tr>
                <th>Posición</th>
                <th>Nombre</th>
                <th>Nombre de invocador(Soloq Challenge)</th>
                <th>Nivel</th>
                <th>Canal de twitch</th>
                <th>Rol</th>
                <th>Elo</th>
            </tr>
        </thead>
        <tbody>
            @php
            $counter = 1;
            @endphp
            @foreach ($summoners as $summoner )
            <tr>
                <td>{{$counter}}</td>
                {{-- {{$summoner}} --}}
                <td>{{$summoner['name']}}</td>
                <td>{{$summoner['summoner_name']}}</td>
                <td>{{$summoner['level']}}</td>
                <td>{{$summoner['twitch_channel']}}</td>
                <td>{{$summoner['main_role']}}</td>
                @php
                $league = Str::of($summoner['tier'] .' '. $summoner['rank'].' '. $summoner['points'])->trim();
                @endphp
                <td>
                    {{$league!='' ? $league.'pl' : 'N/A'}}</td>
                </td>
            </tr>
            @php
            $counter++;
            @endphp
            @endforeach
        </tbody>
    </table>
</div>