@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <form>
                        <input type="submit" value="Применить">
                    @foreach ($characteristics as $characteristic)
                        <div style="border: 1px solid black">
                        {{ $characteristic->getData('name') }}
                            <hr>

                            @foreach ($valuesForView[$characteristic->id] as $value)
                            <p>
                                <label>{{ $value->getData('value') }}
                                    <input type=checkbox name=filter[{{ $characteristic->id }}][] value="{{ $value->id }}" {{ in_array($value->id, ($_GET['filter'][$characteristic->id]) ?? []) ? 'checked' : ''}}>
                                </label>
                            </p>
                            @endforeach

                        </div>
                    @endforeach
                        <input type="submit" value="Применить">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
