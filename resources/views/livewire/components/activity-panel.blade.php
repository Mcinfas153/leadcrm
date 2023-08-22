<div>
    <li class="timeline-item d-flex position-relative overflow-hidden">
        <div class="timeline-time text-dark flex-shrink-0 text-end">#ref</a></div>
        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
          <span class="timeline-badge border-2 border border-warning flex-shrink-0 my-8"></span>
          <span class="timeline-badge-border d-block flex-shrink-0"></span>
        </div>
        <div class="timeline-desc fs-3 text-dark mt-n1 fw-semibold">{{ Str::lower($activity->information) }} <a href="javascript:void(0)" class="text-primary d-block fw-normal ">{{ dateFormater($activity->created_at) }}</a>
        </div>
    </li>
</div>
