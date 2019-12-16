import java.io.DataInputStream;
import java.io.DataOutputStream;
import java.io.IOException;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.ArrayList;

public class Server {

    ArrayList<UserInfo> user_list = new ArrayList<>();

    String [] str = new String[100];

    // 클라이언트 소켓을 받기위한 변수
    ServerSocket serverSocket;

    // 클라이언트 소켓을 담을 배열
    Socket[] sockets;

    // 클라이언트 index / 들어온 순서대로 값이 주어짐
    int index = 0;

    // EchoChatServer() 생성자 참고
    ServerReceiver[] serverThread;

    // EchoChatServer() 생성자 시작
    public Server() {
        // 클라이언트 소켓을 받기위하여 서버 소켓을 만든다.
        try {
            // 서버 9999포트 할당 // 클라이언트에서 접근할때도 9999번 포트로 접속을 해야함.
            serverSocket = new ServerSocket(10000);
            System.out.println("EchoChatServer start");

            // 소켓 객체 할당
            sockets = new Socket[10000];

            // 클라이언트가 접속할때 마다 thread 생성해줌. main Thread가 모든 일처리를 맡을 수 없기에 나누었음.
            serverThread = new ServerReceiver[10000];

        } catch (IOException e) {
            e.printStackTrace();
        }
    } // EchoChatServer() 생성자 끝

    // EchoChatServer - start() 메서드 시작
    public void start() {

        try {
            this.index = 0;
            // 클라이언트 접속을 기다리는 무한루프 생성
            // 서버가 켜져있는동안 사용자를 받는다.
            while (true) {


                // 클라이언트 접속을 받아 소켓 할당
                sockets[this.index] = serverSocket.accept();
                System.out.println("Client connect  : " + index);

                System.out.println("client index: " + this.index);

                // 데이터 입출력을 위한 ServerReceiver객체 생성 후
                // ServerReceiver객체에 현재 접속된 클라이언트 Socket을 매개변수로 넘겨준다.
                serverThread[this.index] = new ServerReceiver(this.index, sockets[this.index]);

                // 그리고 Thread 시작
                serverThread[this.index].start();

                this.index = this.index + 1;

            } // while 끝

        } catch (IOException e) {

            System.out.println("EchoServer error: " + e.getMessage());
            e.printStackTrace();

        } // try - cathch 끝

    } // EchoChatServer - start() 메서드 끝

    public static void main(String[] args) {
        // 에코 서버 시작
        new Server().start();
    }

    // 내부클래스 ServerReceiver
    public class ServerReceiver extends Thread {

        // EchoChatServer - start()로 부터 넘어온 socket을 받기위한 변수
        Socket socket;

        // 데이터 입 출력
        DataInputStream in;
        DataOutputStream out;

        String read;

        // ServerReceiver 생성자 시작
        public ServerReceiver(int index, Socket sock) {
            this.socket = sock;

            try {

                // 데이터 입출력 객체 생성
                in = new DataInputStream(socket.getInputStream());
                out = new DataOutputStream(socket.getOutputStream());

            } catch (IOException e) {

                System.out.println("ServerReceiver error : " + e.getMessage());
                e.printStackTrace();

            }
        } // ServerReceiver 생성자 끝

        @Override
        public void run() {

            try {

                while ((read = in.readUTF()) != null) {

                    System.out.println("string data : " + read.toString() + "\n\n");

                    try {
                        str = read.toString().split("@@");

                        if(str[0].equals("user_id")) {
                            user_list.add(new UserInfo(str[1], out));
                        }

                        if(str[0].equals("room_create")){
                            sendAll("room_create@@"+str[1]+"@@"+str[2]);
                        }

                        if(str[0].equals("gameRoom")){
                            System.out.println("gameRoom");
                            sendAll("gameRoom@@"+str[1]);
                        }
                        if(str[0].equals("ready")){
                            sendAll("ready@@ready");
                        }

                        if(str[0].equals("start")){
                            sendAll("start@@start");
                        }

                        if(str[0].equals("play")){
                            sendAll("play@@play");
                        }
                        if(str[0].equals("stop")){
                            sendAll("stop@@stop");
                        }

                        if(str[0].equals("pause")){
                            sendAll("pause@@pause");
                        }
                        if(str[0].equals("Umm")){
                            sendAll("Umm@@"+str[1]);
                        }
                        if(str[0].equals("close")){
                            sendAll("close@@close");
                        }
                        if(str[0].equals("dmm")){
                            sendAll("dmm@@dd");
                        }
                        if(str[0].equals("master_exit")){
                            sendAll("master_exit@@master_exit");
                        }
                        if(str[0].equals("student_out")){
                            sendAll("student_out@@student_out");
                        }

                    }
                    catch (Exception e) {

                    }
                }

            } catch (IOException e) {
//                System.out.println("error : " + e.getMessage());
//                e.printStackTrace();
//
            }

        } // run 끝

        public void sendAll(final String msg){
            for (int i = 0; i < user_list.size(); i++) {

                try {
                    DataOutputStream out = user_list.get(i).getOut();

                    System.out.println("message : " + msg);

                    out.writeUTF(msg);
                    out.flush();
                } catch (IOException e) {
                    e.printStackTrace();
                }


            }
        }

    }
}