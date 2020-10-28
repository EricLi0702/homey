<template>
    <div class="col-12 col-md-4 m-0 p-0 pr-md-4">
        <div class="box-block">
            <div class="community-category-title p-3">
                Categories
            </div>
            <div class="community-category-list p-3">
                <div class=" ccl-item d-flex justify-content-between">
                    <p>1. Notice to Pay or Quit</p>
                    <Badge type="normal" :count="17"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>2. Notice to Cure or Quit</p>
                    <Badge type="normal" :count="5"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>3. Unconditional Quit Notice</p>
                    <Badge type="normal" :count="23"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>4. Notice of Transfer of Ownership/Management</p>
                    <Badge type="normal" :count="56"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>5. Notice of Non-Renewal</p>
                    <Badge type="normal" :count="19"></Badge>
                </div>
                <div class=" ccl-item d-flex justify-content-between">
                    <p>6. Notice of Rent Increase</p>
                    <Badge type="normal" :count="38"></Badge>
                </div>
            </div>
        </div>
        <div class="box-block">
            <div class="community-category-title p-3">
                Importantance on this month
            </div>
            <div class="community-category-list p-3">
                <div class=" ccl-item">
                    <p>Architecture.</p>
                    <Progress class="w-100" :percent="45" :stroke-width="20" status="active" text-inside />
                </div>
                <div class=" ccl-item">
                    <p>House.</p>
                    <Progress class="w-100" :percent="78" :stroke-width="20" stroke-color="#D14429" status="active" text-inside />
                </div>
                <div class=" ccl-item">
                    <p>Property.</p>
                    <Progress class="w-100" :percent="96" :stroke-width="20" stroke-color="#04619F" status="active" text-inside />
                </div>
                <div class=" ccl-item ">
                    <p>Real Estate.</p>
                    <Progress class="w-100" :percent="63" :stroke-width="20" stroke-color="#000000" status="active" text-inside />
                </div>
                <div class=" ccl-item">
                    <p>Residence.</p>
                    <Progress class="w-100" :percent="89" :stroke-width="20" stroke-color="#737375" status="active" text-inside />
                </div>
                <!-- <div class=" ccl-item">
                    <p>Lorem ipsum dolor sit amet.</p>
                    <Progress class="w-100" :percent="23" :stroke-width="20" stroke-color="#F6684E" status="active" text-inside />
                </div> -->
            </div>
        </div>
        <div class="box-block">
            <div class="community-category-title p-3">
                My Activity Thread
            </div>
            <div class="community-category-list p-3">
                <div class=" ccl-item d-flex justify-content-between">
                    <p>This Dock Turns Your iPhone Into a Bedside Lamp</p>
                </div>
                <Divider />
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Who Wins in the Battle for Power on the Internet?</p>
                </div>
                <Divider />
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Sony QX10: A Funky, Overpriced Lens Camera for Your Smartphone</p>
                </div>
                <Divider />
                <div class=" ccl-item d-flex justify-content-between">
                    <p>FedEx Simplifies Shipping for Small Businesses</p>
                </div>
                <Divider />
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Loud and Brave: Saudi Women Set to Protest Driving Ban</p>
                </div>
                <Divider />
                <div class=" ccl-item d-flex justify-content-between">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
            </div>
        </div>

    </div>
</template>