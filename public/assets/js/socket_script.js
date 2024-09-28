
const socket = io("http://localhost:3000"); // Assumes Socket.IO server is on the same host and port

const addStudentCard = document.getElementById('add_student_card');

function debounce(func, wait) {
    let timeout;
    return function (...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), wait);
    };
}

const debouncedFunction = debounce((data, card) => {
    if (data.length > 0) {
        alert("this card is already used registered");
    } else {
        addStudentCard.value = card;
    }
}, 500);


const debouncedFunction2 = debounce((data) => {
    if (data.length > 0) {

        document.getElementById('studentImage').src = "http://127.0.0.1:8000/storage/student/" + data[0].image
        document.getElementById('studentName').innerHTML = data[0].first_name + " " + data[0].last_name
        document.getElementById('studentEmail').innerHTML = data[0].email;

        var link = document.createElement('a');
        link.href = '/view-student/'+data[0].id;
        link.className = 'btn btn-primary ml-2';
        link.textContent = 'View more';
        document.getElementById('studentFooter').innerHTML = "";
        document.getElementById('studentFooter').appendChild(link);
    } else {
        alert("this card is not registered");
    }
}, 500);

socket.on("connect", () => {
    console.log("Connected to server");
});
socket.on("disconnect", () => {
    console.log("Disconnected from server");
});

socket.on("arduino_send", (data) => {
    var currentPathname = window.location.pathname;

    if (currentPathname === "/control-student" || currentPathname === "/student-management") {
        const array = JSON.parse(data);
        let firstData = "";
        array.forEach((item, index) => {
            firstData = item;
        });

        if (firstData.length > 0) {
            let len = firstData.length;
            cartDetail = firstData.substring(10, len);
            // addStudentCard.value = data;
            const url = new URL("http://localhost:3000/student-cart");
            url.search = new URLSearchParams({ cardId: cartDetail });
            fetch(url)
                .then((response) => response.json())
                .then(async (data) => {
                    if (currentPathname === "/student-management") {
                        debouncedFunction(data, cartDetail);
                    } else {
                        debouncedFunction2(data, cartDetail);
                    }
                })
                .catch((error) => {
                    alert("Error fetching data:", error);
                    console.error("Error fetching data:", error);
                });


            // debouncedFunction(cartDetail);
        }

    }

    // document.getElementById("div").innerHTML = str;
});
