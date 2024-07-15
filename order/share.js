document.addEventListener('DOMContentLoaded', function() {
    const shareButtons = document.querySelectorAll('.share-btn');

    shareButtons.forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.dataset.orderid;
            const modelName = this.dataset.modelname;
            const orderPrice = this.dataset.orderprice;
            const variant = this.dataset.variant; // Corrected variable name
            const mobileNumber = this.dataset.mobilenumber;
            const accountHolder = this.dataset.accountholder;
            const storeName = this.dataset.storename;

            // Populate modal body with order details
            const shareModal = document.getElementById('shareModal');
            const modalBody = shareModal.querySelector('.modal-body');
            modalBody.innerHTML = `
                <p>Order ID: ${orderId}</p>
                <p>Product: ${modelName}</p>
                <p>Price: ₹${orderPrice}</p>
                <p>Variant: ${variant}</p> <!-- Corrected variable name -->
                <p>Mobile No: ${mobileNumber}</p>
                <p>Account Holder Name: ${accountHolder}</p>
                <p>Store: ${storeName}</p>
            `;

            // Show modal
            $('#shareModal').modal('show');
        });
    });

    // Share with Delivery Agent
    document.getElementById('shareDeliveryAgentBtn').addEventListener('click', function() {
        const shareModal = document.getElementById('shareModal');
        const orderId = shareModal.querySelector('.modal-body p:nth-child(1)').textContent.slice(10);
        const modelName = shareModal.querySelector('.modal-body p:nth-child(2)').textContent.slice(9);
        const orderPrice = shareModal.querySelector('.modal-body p:nth-child(3)').textContent.slice(7);
        const variant = shareModal.querySelector('.modal-body p:nth-child(4)').textContent.slice(9);
        const mobileNumber = shareModal.querySelector('.modal-body p:nth-child(5)').textContent.slice(10);
        const accountHolder = shareModal.querySelector('.modal-body p:nth-child(6)').textContent.slice(20);
        const storeName = shareModal.querySelector('.modal-body p:nth-child(7)').textContent.slice(7);

        const whatsappMessage = `Product: ${modelName}\nMobile No: ${mobileNumber}\nAccount Holder Name: ${accountHolder}\nOTP: 000000`;
        window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent(whatsappMessage)}`, '_blank');
    });

    // Share with Shopkeeper
    document.getElementById('shareShopkeeperBtn').addEventListener('click', function() {
        const shareModal = document.getElementById('shareModal');
        const orderId = shareModal.querySelector('.modal-body p:nth-child(1)').textContent.slice(10);
        const modelName = shareModal.querySelector('.modal-body p:nth-child(2)').textContent.slice(9);
        const orderPrice = shareModal.querySelector('.modal-body p:nth-child(3)').textContent.slice(7);
        const variant = shareModal.querySelector('.modal-body p:nth-child(4)').textContent.slice(9);
        const mobileNumber = shareModal.querySelector('.modal-body p:nth-child(5)').textContent.slice(10);
        const accountHolder = shareModal.querySelector('.modal-body p:nth-child(6)').textContent.slice(23);
        const storeName = shareModal.querySelector('.modal-body p:nth-child(7)').textContent.slice(7);

        const whatsappMessage = `Product: ${modelName}\nPrice: ${orderPrice}\nVariant: ${variant}`;
        window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent(whatsappMessage)}`, '_blank');
    });

    // Copy for Delivery Agent
    document.getElementById('copyDeliveryAgentBtn').addEventListener('click', function() {
        const shareModal = document.getElementById('shareModal');
        const modelName = shareModal.querySelector('.modal-body p:nth-child(2)').textContent.slice(9);
        const variant = shareModal.querySelector('.modal-body p:nth-child(4)').textContent.slice(9);
        const mobileNumber = shareModal.querySelector('.modal-body p:nth-child(5)').textContent.slice(13);
        const accountHolder = shareModal.querySelector('.modal-body p:nth-child(6)').textContent.slice(23);

        const shopkeeperData = `Product Name: ${modelName}\nVariant: ${variant}\nMobile No: ${mobileNumber}\nAccount Holder Name: ${accountHolder}\nDelevery OTP: ******`;
        navigator.clipboard.writeText(shopkeeperData).then(function() {
            alert('Data copied successfully for Delivery Agent!');
        }, function() {
            alert('Copying data for Delivery Agent failed!');
        });
    });

    // Copy for Shopkeeper
    document.getElementById('copyShopkeeperBtn').addEventListener('click', function() {
        const shareModal = document.getElementById('shareModal');
        const modelName = shareModal.querySelector('.modal-body p:nth-child(2)').textContent.slice(9);
        const variant = shareModal.querySelector('.modal-body p:nth-child(4)').textContent.slice(9);
        const orderPrice = shareModal.querySelector('.modal-body p:nth-child(3)').textContent.slice(7);

        const shopkeeperData = `Product Name: ${modelName}\nVariant: ${variant}\nPrice: ₹${orderPrice}`;
        navigator.clipboard.writeText(shopkeeperData).then(function() {
            alert('Data copied successfully for Shopkeeper!');
        }, function() {
            alert('Copying data for Shopkeeper failed!');
        });
    });
});