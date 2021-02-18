                        <tr class="collapse show source">
                            <td><a href="{{ action('SourceController@show', $source->so_id) }}">{{ $source->so_name }}</a></td>
                            <td><a href="{{ action('SourceController@show', $source->so_id) }}">{{$source->so_description}}</a></td>
                            <td>
                                <form action="{{action('SourceController@destroy', $source->so_id)}}" method="post" class="delete-frm float-right" data-confirm="Are you sure to delete data source: '{{$source->so_name }}'?">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </td>                            
                        </tr>
