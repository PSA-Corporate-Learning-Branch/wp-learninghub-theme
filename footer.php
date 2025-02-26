<div id="bcgovfoot" class="bg-gov-blue flex-grow-1">
    <footer class="site-footer container-lg p-4">
        <div class="row">
            <div class="col-md-5">
                <h5 class="gov-yellow">The LearningHUB</h5>
                <ul>
                    <li class="mb-1"><a aria-current="page" href="/learninghub/">Home</a></li>
                    <li class="mb-1"><a href="/learninghub/about/">About</a> </li>
                    <li class="mb-1"><a href="/learninghub/what-is-corp-learning-framework/">Corporate Learning Framework</a></li>
                    <li class="mb-1"><a href="/learninghub/corporate-learning-partners/">Corporate Learning Partners</a></li>
                    <li class="mb-1"><a href="/learninghub/intake/">Intake for Corporate Learning</a></li>
                    <li class="mb-1"><a href="/learninghub/filter/">All Courses</a></li>
                    <li class="mb-1"><a href="/learninghub/foundational-corporate-learning/">Mandatory and Foundational Learning</a></li>
                    <li class="mb-1"><a href="/learninghub/categories/">Course Categorization</a></li>
                    <li class="mb-1"><a href="/learninghub/learning-systems/">Learning Platforms</a></li>
                </ul>
            </div>
            <div class="col-md-7">
                <h5 class="gov-yellow">Contact</h5>
                <p>Have a question about corporate learning? <a href="https://sfs7.gov.bc.ca/affwebservices/public/saml2sso?SPID=urn:ca:bc:gov:customerportal:prod" class="customize-unpreviewable">Submit an AskMyHR service request</a> using the category "Learning Centre".</p>
                <p>Want to add a course to the LearningHUB catalogue? Visit the <a href="/learninghub/intake/">Intake for Corporate Learning</a> page for more information.</p>
                <h5 class="gov-yellow">Accommodations</h5>
                <p class="mb-0">If you have question about the accessibility of any offering on the LearningHUB, or you would like to request an accommodation, please <a href="https://sfs7.gov.bc.ca/affwebservices/public/saml2sso?SPID=urn:ca:bc:gov:customerportal:prod">submit an AskMyHR service request</a> using the category "Learning Centre > Course Information".</p>
            </div>

        </div>
        <div class="site-info d-block mt-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between border-top border-warning pt-1">
                <div class="me-3 my-3 flex-grow-1">
                    <p class="mb-0">The BC Public Service acknowledges the territories of First Nations around B.C. and is grateful to carry out our work on these lands. We acknowledge the rights, interests, priorities and concerns of all Indigenous Peoples (First Nations, Métis and Inuit), respecting and acknowledging their distinct cultures, histories, rights, laws and governments.</p>
                </div>

                <img class="mx-auto mx-lg-0 mt-3 mb-2 mt-lg-auto" style="min-height: 50px; max-height: 100px;" src="https://learn.bcpublicservice.gov.bc.ca/common-components/where-ideas-work-whitetext.svg" height="100" width="380" alt="Where Ideas Work logo">
            </div>
            <div class="fs-6 d-block text-end border-top border-warning pt-1">
                Proudly powered by <a href="https://wordpress.org/" class="text-white">WordPress</a>. </div>
        </div><!-- .site-info -->
    </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const OFFSET_DEFAULT = 165; // Height of the sticky top navigation for screens md and larger
        const OFFSET_SMALL = 365; // Height adjustment for smaller screens where tabs are stacked, depends on how many tabs to adjust offset

        // Determine the current offset based on the screen size
        function getOffset() {
            return window.innerWidth >= 768 ? OFFSET_DEFAULT : OFFSET_SMALL; // Bootstrap md breakpoint is 768px
        }

        // Scroll to the target element with an offset
        function scrollToWithOffset(element) {
            const offset = getOffset();
            const rect = element.getBoundingClientRect();
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const targetPosition = rect.top + scrollTop - offset;

            window.scrollTo({
                top: targetPosition,
                behavior: "smooth"
            });
        }

        // Check if there is a hash in the URL
        const hash = window.location.hash;
        if (hash) {
            const targetTab = document.querySelector(`[href="${hash}"]`);
            const targetPane = document.querySelector(hash);

            // If the target tab exists, activate it and scroll to it with an offset
            if (targetTab && targetPane) {
                const tabInstance = new bootstrap.Tab(targetTab);
                tabInstance.show();

                // Scroll to the tabbed section with an offset
                scrollToWithOffset(targetPane);
            }
        }

        // Add event listener to update the URL hash when switching tabs
        const tabLinks = document.querySelectorAll('[data-bs-toggle="tab"]');
        tabLinks.forEach(tab => {
            tab.addEventListener("shown.bs.tab", function(event) {
                const targetId = event.target.getAttribute("href");
                history.pushState(null, "", targetId);

                // Scroll to the newly activated tab's content with an offset
                const targetPane = document.querySelector(targetId);
                if (targetPane) {
                    scrollToWithOffset(targetPane);
                }
            });
        });

        // Adjust scrolling behavior on window resize
        window.addEventListener("resize", function() {
            const hash = window.location.hash;
            if (hash) {
                const targetPane = document.querySelector(hash);
                if (targetPane) {
                    scrollToWithOffset(targetPane);
                }
            }
        });
    });
</script>

</body>

</html>