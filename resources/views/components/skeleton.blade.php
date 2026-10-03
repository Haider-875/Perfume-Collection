@props(['height' => '200px', 'width' => '100%'])

<div style="width: {{ $width }}; height: {{ $height }}; background: linear-gradient(90deg, rgba(255,255,255,0.02) 25%, rgba(201,162,75,0.08) 50%, rgba(255,255,255,0.02) 75%); background-size: 200% 100%; border-radius: var(--radius-sm); animation: skeletonShimmer 2s infinite ease-in-out;"></div>

<style>
@keyframes skeletonShimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
</style>
