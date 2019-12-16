import java.io.DataOutputStream;

public class UserInfo {
    String user_name;
    DataOutputStream out;

    public UserInfo(String user_name, DataOutputStream out) {
        this.user_name = user_name;
        this.out = out;
    }

    public String getUser_name() {
        return user_name;
    }

    public void setUser_name(String user_name) {
        this.user_name = user_name;
    }

    public DataOutputStream getOut() {
        return out;
    }

    public void setOut(DataOutputStream out) {
        this.out = out;
    }

}