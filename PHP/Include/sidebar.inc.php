<div class="sidebar">
	<div class="collapsedSidebar">
		<button class="imageButton sbExpandArrow">
		<img class="sidebarArrowImg" style="transform: rotate(180deg);" onClick="expandSidebar()" src="../IMG/back.png"></img>
		</button>		
	</div>
	<div class="expandedSidebar">
		<button class="imageButton sbCollapseArrow">
			<img class="sidebarArrowImg" onClick="collapseSidebar()" src="../IMG/back.png"></img>
		</button>
		<div class="sidebarContent">
				<p class="button"><a onclick="callController('.content', 'proposalController')">Proposals</a></p>
				<p class="button"><a onClick="callController('.content', 'contactController');">Contact</a></p>
				<p class="button"><a onClick="callController('.content', 'aboutUsController');">About us</a></p>	
		</div>
	</div>
         
</div>