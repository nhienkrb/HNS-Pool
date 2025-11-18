 @props(['project' => null])
 @if ($project)
     <div class="relative rounded-lg overflow-hidden">
         <a href="{!!get_permalink($project->ID)!!}">
             @if (has_post_thumbnail($project->ID))
                 {!! get_the_post_thumbnail($project->ID, 'medium', [
                     'class' => 'w-full h-64 object-cover',
                     'alt' => $project->post_title,
                 ]) !!}
             @else
                 <img src="@asset('images/trip1.png')" class="w-full h-64 object-cover" />
             @endif
             <div
                 class="absolute uppercase font-semibold bottom-0 left-0 w-full bg-linear-to-t from-black/60 to-transparent text-white text-xl p-4">
                 {{ $project->post_title }}
             </div>
         </a>
     </div>
 @endif
