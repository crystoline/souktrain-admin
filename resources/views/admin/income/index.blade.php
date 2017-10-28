

<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Incomes</h3>

    </div>
    <div class="panel-body">
        <div class="pills-struct mt-40">
            <ul role="tablist" class="nav nav-pills" id="myTabs_6">
                <li role="presentation">
                    <a aria-expanded="true" role="tab" id="home_tab_6" href="{{ route('admin.income.owner', ['owner' => 'souktrain']) }}"
                       data-ajax="true" data-dst="#tab-content" data-temp="true" aria-expanded="false">
                        Souktrain Income
                    </a>
                </li>
                <li role="presentation" class=""><a id="profile_tab_6" role="tab"
                href="{{ route('admin.income.owner', ['owner' => 'netronit']) }}"
                data-ajax="true" data-dst="#tab-content" data-temp="true" aria-expanded="false">Netron IT Income</a></li>
            </ul>
            <div class="tab-content" id="myTabContent_6">
                <div id="tab-content" class="tab-pane fade active in" role="tabpanel">

                </div>

            </div>
        </div>

    </div>
</div>
<script>
    $(function () {
       @if($message = session('notify-msg'))
        swal('Success', '{{$message}}', 'success');
        @endif
    })
</script>